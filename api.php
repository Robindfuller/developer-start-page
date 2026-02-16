<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$dataFile = __DIR__ . '/data.json';

function loadData() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return array('categories' => array(), 'timeBlocks' => array(), 'midiPlaylist' => array());
    }
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true);
    if (!$data) return array('categories' => array(), 'timeBlocks' => array(), 'midiPlaylist' => array());
    if (empty($data['timeBlocks'])) $data['timeBlocks'] = array();
    if (empty($data['midiPlaylist'])) $data['midiPlaylist'] = array();
    return $data;
}

function generateTimeBlockId() {
    return 'tb-' . uniqid();
}

function saveData($data) {
    global $dataFile;
    if (empty($data['categories'])) $data['categories'] = array();
    if (empty($data['timeBlocks'])) $data['timeBlocks'] = array();
    if (empty($data['midiPlaylist'])) $data['midiPlaylist'] = array();
    usort($data['timeBlocks'], function($a, $b) {
        $oa = isset($a['order']) ? $a['order'] : 0;
        $ob = isset($b['order']) ? $b['order'] : 0;
        return $oa - $ob;
    });
    usort($data['categories'], function($a, $b) {
        $oa = isset($a['order']) ? $a['order'] : 0;
        $ob = isset($b['order']) ? $b['order'] : 0;
        return $oa - $ob;
    });
    foreach ($data['categories'] as &$cat) {
        if (!empty($cat['items'])) {
            usort($cat['items'], function($a, $b) {
                $oa = isset($a['order']) ? $a['order'] : 0;
                $ob = isset($b['order']) ? $b['order'] : 0;
                return $oa - $ob;
            });
        }
    }
    return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function generateId() {
    return 'item-' . uniqid();
}

function generateCategoryId() {
    return 'cat-' . uniqid();
}

function generateMidiTrackId() {
    return 'midi-' . uniqid();
}

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

// Handle MIDI file upload (multipart/form-data)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'uploadMidi' && !empty($_FILES['file'])) {
    $midiDir = __DIR__ . '/midi';
    if (!is_dir($midiDir)) {
        mkdir($midiDir, 0755, true);
    }
    $file = $_FILES['file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, array('mid', 'midi'))) {
        echo json_encode(['error' => 'Only .mid or .midi files are allowed']);
        exit;
    }
    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
    $target = $midiDir . '/' . $safeName;
    if (move_uploaded_file($file['tmp_name'], $target)) {
        echo json_encode(['success' => true, 'url' => 'midi/' . $safeName, 'name' => pathinfo($file['name'], PATHINFO_FILENAME)]);
    } else {
        echo json_encode(['error' => 'Upload failed']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($action === 'get' || $action === '')) {
    echo json_encode(loadData());
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
if (!$input) {
    $input = $_POST;
}
$data = loadData();

switch ($action) {
    case 'add':
        $categoryId = isset($input['categoryId']) ? $input['categoryId'] : '';
        $item = array(
            'id' => generateId(),
            'title' => trim(isset($input['title']) ? $input['title'] : ''),
            'subtitle' => trim(isset($input['subtitle']) ? $input['subtitle'] : ''),
            'url' => trim(isset($input['url']) ? $input['url'] : ''),
            'color' => isset($input['color']) ? $input['color'] : '',
            'order' => 999
        );
        foreach ($data['categories'] as &$cat) {
            if ($cat['id'] === $categoryId) {
                $cat['items'] = isset($cat['items']) ? $cat['items'] : array();
                $maxOrder = 0;
                foreach ($cat['items'] as $i) {
                    $maxOrder = max($maxOrder, isset($i['order']) ? $i['order'] : 0);
                }
                $item['order'] = $maxOrder + 1;
                $cat['items'][] = $item;
                break;
            }
        }
        saveData($data);
        echo json_encode(['success' => true, 'item' => $item]);
        break;

    case 'edit':
        $itemId = isset($input['id']) ? $input['id'] : '';
        $found = false;
        foreach ($data['categories'] as &$cat) {
            foreach (isset($cat['items']) ? $cat['items'] : array() as &$item) {
                if ($item['id'] === $itemId) {
                    if (isset($input['title'])) $item['title'] = trim($input['title']);
                    if (isset($input['subtitle'])) $item['subtitle'] = trim($input['subtitle']);
                    if (isset($input['url'])) $item['url'] = trim($input['url']);
                    if (isset($input['color'])) $item['color'] = $input['color'];
                    $found = true;
                    break 2;
                }
            }
        }
        saveData($data);
        echo json_encode(['success' => $found]);
        break;

    case 'delete':
        $itemId = isset($input['id']) ? $input['id'] : '';
        foreach ($data['categories'] as &$cat) {
            $items = isset($cat['items']) ? $cat['items'] : array();
            $cat['items'] = array_values(array_filter($items, function($i) use ($itemId) {
                return (isset($i['id']) ? $i['id'] : '') !== $itemId;
            }));
        }
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    case 'reorder':
        $categoryId = isset($input['categoryId']) ? $input['categoryId'] : '';
        $itemIds = isset($input['itemIds']) ? $input['itemIds'] : array();
        foreach ($data['categories'] as &$cat) {
            if ($cat['id'] === $categoryId) {
                $order = 0;
                foreach ($itemIds as $id) {
                    foreach (isset($cat['items']) ? $cat['items'] : array() as &$item) {
                        if ($item['id'] === $id) {
                            $item['order'] = $order++;
                            break;
                        }
                    }
                }
                break;
            }
        }
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    case 'reorderCategories':
        $categoryIds = isset($input['categoryIds']) ? $input['categoryIds'] : array();
        $order = 0;
        foreach ($categoryIds as $id) {
            foreach ($data['categories'] as &$cat) {
                if ($cat['id'] === $id) {
                    $cat['order'] = $order++;
                    break;
                }
            }
        }
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    case 'addCategory':
        $title = trim(isset($input['title']) ? $input['title'] : '');
        if ($title === '') {
            echo json_encode(['error' => 'Title is required']);
            exit;
        }
        $maxOrder = -1;
        foreach ($data['categories'] as $c) {
            $maxOrder = max($maxOrder, isset($c['order']) ? $c['order'] : 0);
        }
        $category = array(
            'id' => generateCategoryId(),
            'title' => $title,
            'order' => $maxOrder + 1,
            'items' => array()
        );
        $data['categories'][] = $category;
        saveData($data);
        echo json_encode(['success' => true, 'category' => $category]);
        break;

    case 'addTimeBlock':
        $blocks = isset($data['timeBlocks']) ? $data['timeBlocks'] : array();
        $maxOrder = -1;
        foreach ($blocks as $b) {
            $maxOrder = max($maxOrder, isset($b['order']) ? $b['order'] : 0);
        }
        $block = array(
            'id' => generateTimeBlockId(),
            'label' => trim(isset($input['label']) ? $input['label'] : 'Block'),
            'start' => floatval(isset($input['start']) ? $input['start'] : 0),
            'end' => floatval(isset($input['end']) ? $input['end'] : 1),
            'color' => isset($input['color']) ? $input['color'] : '#00ff88',
            'order' => $maxOrder + 1
        );
        $data['timeBlocks'][] = $block;
        saveData($data);
        echo json_encode(['success' => true, 'block' => $block]);
        break;

    case 'editTimeBlock':
        $blockId = isset($input['id']) ? $input['id'] : '';
        $found = false;
        foreach ($data['timeBlocks'] as &$b) {
            if (isset($b['id']) && $b['id'] === $blockId) {
                if (isset($input['label'])) $b['label'] = trim($input['label']);
                if (isset($input['start'])) $b['start'] = floatval($input['start']);
                if (isset($input['end'])) $b['end'] = floatval($input['end']);
                if (isset($input['color'])) $b['color'] = $input['color'];
                $found = true;
                break;
            }
        }
        saveData($data);
        echo json_encode(['success' => $found]);
        break;

    case 'deleteTimeBlock':
        $blockId = isset($input['id']) ? $input['id'] : '';
        $data['timeBlocks'] = array_values(array_filter($data['timeBlocks'], function($b) use ($blockId) {
            return (isset($b['id']) ? $b['id'] : '') !== $blockId;
        }));
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    case 'addMidiTrack':
        $playlist = isset($data['midiPlaylist']) ? $data['midiPlaylist'] : array();
        $maxOrder = -1;
        foreach ($playlist as $t) {
            $maxOrder = max($maxOrder, isset($t['order']) ? $t['order'] : 0);
        }
        $url = trim(isset($input['url']) ? $input['url'] : '');
        $name = trim(isset($input['name']) ? $input['name'] : pathinfo($url, PATHINFO_FILENAME) ?: 'Track');
        if ($url === '') {
            echo json_encode(['error' => 'URL is required']);
            exit;
        }
        $track = array(
            'id' => generateMidiTrackId(),
            'name' => $name,
            'url' => $url,
            'order' => $maxOrder + 1
        );
        $data['midiPlaylist'][] = $track;
        saveData($data);
        echo json_encode(['success' => true, 'track' => $track]);
        break;

    case 'removeMidiTrack':
        $trackId = isset($input['id']) ? $input['id'] : '';
        $data['midiPlaylist'] = array_values(array_filter($data['midiPlaylist'], function($t) use ($trackId) {
            return (isset($t['id']) ? $t['id'] : '') !== $trackId;
        }));
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    case 'reorderMidiPlaylist':
        $trackIds = isset($input['trackIds']) ? $input['trackIds'] : array();
        $order = 0;
        foreach ($trackIds as $id) {
            foreach ($data['midiPlaylist'] as &$t) {
                if (isset($t['id']) && $t['id'] === $id) {
                    $t['order'] = $order++;
                    break;
                }
            }
        }
        saveData($data);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown action']);
}
