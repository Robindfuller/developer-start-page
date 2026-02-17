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
        return array('categories' => array(), 'events' => array(), 'midiPlaylist' => array());
    }
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true);
    if (!$data) return array('categories' => array(), 'events' => array(), 'midiPlaylist' => array());
    if (isset($data['timeBlocks']) && !isset($data['events'])) {
        $data['events'] = $data['timeBlocks'];
        unset($data['timeBlocks']);
    }
    if (empty($data['events'])) $data['events'] = array();
    foreach ($data['events'] as &$b) {
        if (isset($b['start']) && !isset($b['time'])) { $b['time'] = $b['start']; unset($b['start']); unset($b['end']); }
    }
    if (empty($data['midiPlaylist'])) $data['midiPlaylist'] = array();
    return $data;
}

function generateTimeBlockId() {
    return 'tb-' . uniqid();
}

function saveData($data) {
    global $dataFile;
    if (empty($data['categories'])) $data['categories'] = array();
    if (empty($data['events'])) $data['events'] = array();
    foreach ($data['events'] as &$b) {
        if (isset($b['start']) && !isset($b['time'])) { $b['time'] = $b['start']; unset($b['start']); unset($b['end']); }
    }
    if (empty($data['midiPlaylist'])) $data['midiPlaylist'] = array();
    usort($data['events'], function($a, $b) {
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
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $tmpFile = $dataFile . '.tmp.' . getmypid();
    $written = file_put_contents($tmpFile, $json);
    if ($written === false) {
        error_log('saveData failed: could not write to ' . $tmpFile . ' (check permissions)');
        return false;
    }
    if (!rename($tmpFile, $dataFile)) {
        @unlink($tmpFile);
        error_log('saveData failed: could not rename ' . $tmpFile . ' to ' . $dataFile . ' (file may be locked - close in editor)');
        return false;
    }
    return $written;
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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'debug') {
    header('Cache-Control: no-store, no-cache');
    $path = realpath($dataFile) ?: $dataFile;
    $out = [
        'dataFile' => $dataFile,
        'resolvedPath' => realpath($dataFile) ?: '(file does not exist)',
        'fileExists' => file_exists($dataFile),
        'isWritable' => file_exists($dataFile) ? is_writable($dataFile) : is_writable(dirname($dataFile)),
        'cwd' => getcwd(),
        '__DIR__' => __DIR__
    ];
    $testFile = __DIR__ . '/data.json.api-write-test';
    $marker = 'api-write-test-' . time();
    if (file_put_contents($testFile, $marker) !== false) {
        $readBack = file_get_contents($testFile);
        @unlink($testFile);
        $out['writeTestFile'] = $testFile;
        $out['writeTestPersisted'] = ($readBack === $marker);
    }
    echo json_encode($out);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($action === 'get' || $action === '')) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
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
if (empty($action) && !empty($input['action'])) {
    $action = $input['action'];
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
        if (!$found) {
            echo json_encode(['success' => false, 'error' => 'Item not found.']);
            exit;
        }
        $canWrite = file_exists($dataFile) ? is_writable($dataFile) : is_writable(dirname($dataFile));
        if (!$canWrite) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'data.json is not writable. Check permissions. Path: ' . $dataFile]);
            exit;
        }
        $written = saveData($data);
        if ($written === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Write failed. Path: ' . $dataFile]);
            exit;
        }
        // Verify: read back and confirm our change persisted
        clearstatcache(true, $dataFile);
        $verify = @file_get_contents($dataFile);
        if ($verify !== false) {
            $check = json_decode($verify, true);
            $expectedUrl = isset($input['url']) ? trim($input['url']) : null;
            foreach (isset($check['categories']) ? $check['categories'] : array() as $c) {
                foreach (isset($c['items']) ? $c['items'] : array() as $i) {
                    if ((isset($i['id']) ? $i['id'] : '') === $itemId) {
                        $actualUrl = isset($i['url']) ? $i['url'] : '';
                        if ($expectedUrl !== null && $actualUrl !== $expectedUrl) {
                            error_log('saveData verify failed: expected ' . $expectedUrl . ' got ' . $actualUrl . ' - data.json may be open in an editor (close it)');
                            http_response_code(500);
                            echo json_encode([
                                'success' => false,
                                'error' => 'Save did not persist. Close data.json in your editor and try again.',
                                '_debug' => ['expected' => $expectedUrl, 'actual' => $actualUrl]
                            ]);
                            exit;
                        }
                        break 2;
                    }
                }
            }
        }
        echo json_encode(['success' => true]);
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
        if (!is_array($itemIds)) {
            $itemIds = array_values($itemIds);
        }
        $reordered = false;
        foreach ($data['categories'] as &$cat) {
            if ($cat['id'] === $categoryId && !empty($cat['items'])) {
                $itemsById = array();
                foreach ($cat['items'] as $item) {
                    $itemsById[$item['id']] = $item;
                }
                $newItems = array();
                $addedIds = array();
                foreach ($itemIds as $id) {
                    $sid = (string) $id;
                    if (isset($itemsById[$sid])) {
                        $itemsById[$sid]['order'] = count($newItems);
                        $newItems[] = $itemsById[$sid];
                        $addedIds[] = $itemsById[$sid]['id'];
                    }
                }
                foreach ($cat['items'] as $item) {
                    if (!in_array($item['id'], $addedIds)) {
                        $item['order'] = count($newItems);
                        $newItems[] = $item;
                    }
                }
                $cat['items'] = $newItems;
                $reordered = true;
                break;
            }
        }
        if (!$reordered) {
            http_response_code(400);
            echo json_encode(['error' => 'Category not found or no items to reorder']);
            exit;
        }
        if (saveData($data) === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save data']);
            exit;
        }
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
        $blocks = isset($data['events']) ? $data['events'] : array();
        $maxOrder = -1;
        foreach ($blocks as $b) {
            $maxOrder = max($maxOrder, isset($b['order']) ? $b['order'] : 0);
        }
        $block = array(
            'id' => generateTimeBlockId(),
            'label' => trim(isset($input['label']) ? $input['label'] : 'Event'),
            'time' => floatval(isset($input['time']) ? $input['time'] : 0),
            'order' => $maxOrder + 1
        );
        $data['events'][] = $block;
        saveData($data);
        echo json_encode(['success' => true, 'block' => $block]);
        break;

    case 'editTimeBlock':
        $blockId = isset($input['id']) ? $input['id'] : '';
        $found = false;
        foreach ($data['events'] as &$b) {
            if (isset($b['id']) && $b['id'] === $blockId) {
                if (isset($input['label'])) $b['label'] = trim($input['label']);
                if (isset($input['time'])) {
                    $b['time'] = floatval($input['time']);
                    unset($b['start']);
                    unset($b['end']);
                }
                if (isset($b['color'])) unset($b['color']);
                $found = true;
                break;
            }
        }
        saveData($data);
        echo json_encode(['success' => $found]);
        break;

    case 'deleteTimeBlock':
        $blockId = isset($input['id']) ? $input['id'] : '';
        $data['events'] = array_values(array_filter($data['events'], function($b) use ($blockId) {
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
