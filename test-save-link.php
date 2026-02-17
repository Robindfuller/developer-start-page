#!/usr/bin/env php
<?php
/**
 * Test script: POSTs a link edit, verifies it persisted, and attempts to resolve if not.
 * Usage: php test-save-link.php [base_url]
 *   base_url e.g. http://localhost:8000 (default: http://localhost:8080)
 * 
 * IMPORTANT: Close data.json in your editor before running. An open file can
 * cause your editor to overwrite API saves, making changes appear to fail.
 * 
 * Run with no server: tests direct file write (CLI context).
 */
$baseUrl = isset($argv[1]) ? rtrim($argv[1], '/') : 'http://localhost:8080';
$projectDir = __DIR__;
$dataFile = $projectDir . '/data.json';

// ---- Helpers ----
function httpGet($url) {
    $ctx = stream_context_create(['http' => ['timeout' => 5, 'ignore_errors' => true]]);
    $r = @file_get_contents($url, false, $ctx);
    return $r !== false ? json_decode($r, true) : null;
}

function httpPost($url, $body) {
    $ctx = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode($body),
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);
    $r = @file_get_contents($url, false, $ctx);
    return $r !== false ? json_decode($r, true) : null;
}

function readDataFile($path) {
    if (!file_exists($path)) return null;
    $json = file_get_contents($path);
    return $json !== false ? json_decode($json, true) : null;
}

function saveDataDirect($data, $path) {
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
}

function findFirstLinkItem($data) {
    foreach (isset($data['categories']) ? $data['categories'] : [] as $cat) {
        foreach (isset($cat['items']) ? $cat['items'] : [] as $item) {
            if (!empty($item['id']) && !empty($item['url'])) return $item;
        }
    }
    return null;
}

function findItemById($data, $id) {
    foreach (isset($data['categories']) ? $data['categories'] : [] as $cat) {
        foreach (isset($cat['items']) ? $cat['items'] : [] as $item) {
            if (($item['id'] ?? '') === $id) return $item;
        }
    }
    return null;
}

// ---- Test 1: Direct write (CLI context) ----
echo "=== Test 1: Direct file write (CLI) ===\n";
$directData = readDataFile($dataFile);
if (!$directData) {
    echo "FAIL: Cannot read data.json\n";
    exit(1);
}
$item = findFirstLinkItem($directData);
if (!$item) {
    echo "FAIL: No link items found in data.json\n";
    exit(1);
}

$origUrl = $item['url'];
$testUrl = $origUrl . (strpos($origUrl, '?') !== false ? '&' : '?') . 'test=' . time();
$itemId = $item['id'];

// Modify explicitly (avoid PHP reference quirks)
$modified = false;
foreach ($directData['categories'] ?? [] as $ci => $cat) {
    foreach ($cat['items'] ?? [] as $ii => $i) {
        if (($i['id'] ?? '') === $itemId) {
            $directData['categories'][$ci]['items'][$ii]['url'] = $testUrl;
            $modified = true;
            break 2;
        }
    }
}
if (!$modified) {
    echo "FAIL: Could not find item $itemId in data\n";
    exit(1);
}

$directOk = saveDataDirect($directData, $dataFile);
$verifyData = readDataFile($dataFile);
$verifyItem = findItemById($verifyData, $itemId);
$directPersisted = $verifyItem && ($verifyItem['url'] ?? '') === $testUrl;

// Restore original
foreach ($directData['categories'] ?? [] as $ci => $cat) {
    foreach ($cat['items'] ?? [] as $ii => $i) {
        if (($i['id'] ?? '') === $itemId) {
            $directData['categories'][$ci]['items'][$ii]['url'] = $origUrl;
            break 2;
        }
    }
}
saveDataDirect($directData, $dataFile);

if ($directOk && $directPersisted) {
    echo "PASS: Direct write works.\n";
} else {
    echo "FAIL: Direct write failed. ";
    if (!$directOk) {
        echo "file_put_contents returned false.\n";
        echo "  Path: $dataFile\n";
        echo "  Writable (file): " . (file_exists($dataFile) && is_writable($dataFile) ? 'yes' : 'no') . "\n";
        echo "  Writable (dir):  " . (is_writable(dirname($dataFile)) ? 'yes' : 'no') . "\n";
        $testFile = dirname($dataFile) . '/data.json.write-test';
        $testWrite = @file_put_contents($testFile, 'test') !== false;
        if ($testWrite) {
            @unlink($testFile);
            echo "  Resolve: Directory IS writable. data.json may be locked (close in editor) or read-only.\n";
        } else {
            echo "  Resolve: Directory not writable. Run from project dir with write access.\n";
        }
        echo "  Try: Close data.json in your editor. Check file is not read-only.\n";
        if (PHP_OS_FAMILY === 'Windows') {
            echo "  Windows: Right-click data.json > Properties > uncheck Read-only.\n";
        } else {
            echo "  Unix: chmod 664 data.json\n";
        }
    } else {
        echo "Write claimed success but verify read back different content.\n";
        echo "  Expected URL: " . substr($testUrl, 0, 80) . "...\n";
        echo "  Got URL:      " . substr($verifyItem['url'] ?? 'null', 0, 80) . "\n";
        echo "  Resolve: Possible path mismatch. Check __DIR__ in api.php matches: $projectDir\n";
    }
}

// ---- Test 2: HTTP API (needs server running) ----
echo "\n=== Test 2: HTTP API (POST edit) ===\n";
echo "Note: Close data.json in your editor first - open files can block persists.\n";
$getUrl = $baseUrl . '/api.php?action=get';
$editUrl = $baseUrl . '/api.php?action=edit';
$debugUrl = $baseUrl . '/api.php?action=debug';

$apiData = httpGet($getUrl);
if (!$apiData) {
    echo "SKIP: Cannot reach $getUrl. Is the server running? Try: php -S localhost:8080\n";
    echo "      Run from project dir: cd " . $projectDir . "\n";
    exit($directOk && $directPersisted ? 0 : 1);
}

$apiItem = findFirstLinkItem($apiData);
if (!$apiItem) {
    echo "FAIL: No items in API response\n";
    exit(1);
}

$apiItemId = $apiItem['id'];
$apiOrigUrl = $apiItem['url'];
$apiTestUrl = $apiOrigUrl . (strpos($apiOrigUrl, '?') !== false ? '&' : '?') . 'test=' . time();

$postBody = [
    'id' => $apiItemId,
    'title' => $apiItem['title'] ?? 'Test',
    'subtitle' => $apiItem['subtitle'] ?? '',
    'url' => $apiTestUrl,
    'color' => $apiItem['color'] ?? ''
];

$editRes = httpPost($editUrl, $postBody);
if (!$editRes) {
    echo "FAIL: POST to $editUrl failed (no response)\n";
    echo "      Ensure server is running: php -S localhost:8080\n";
    exit(1);
}

if (isset($editRes['success']) && $editRes['success'] === false) {
    echo "FAIL: API returned error: " . ($editRes['error'] ?? json_encode($editRes)) . "\n";
    if (!empty($editRes['_debug'])) {
        echo "API debug: " . json_encode($editRes['_debug'], JSON_PRETTY_PRINT) . "\n";
    }
    echo "\nResolve: Close data.json in Cursor/VS Code, then run this test again.\n";
    $debug = httpGet($debugUrl);
    if ($debug) {
        echo "Path info: " . json_encode($debug, JSON_PRETTY_PRINT) . "\n";
    }
    exit(1);
}

// Verify via API
$apiData2 = httpGet($getUrl . '&_=' . time());
$apiItem2 = findItemById($apiData2, $apiItemId);
$apiPersisted = $apiItem2 && ($apiItem2['url'] ?? '') === $apiTestUrl;

// Verify via direct file read
$fileData = readDataFile($dataFile);
$fileItem = findItemById($fileData, $apiItemId);
$filePersisted = $fileItem && ($fileItem['url'] ?? '') === $apiTestUrl;

// Restore original via another POST
httpPost($editUrl, array_merge($postBody, ['url' => $apiOrigUrl]));

if ($apiPersisted || $filePersisted) {
    echo "PASS: Edit persisted" . ($apiPersisted && $filePersisted ? '' : ' (API: ' . ($apiPersisted ? 'yes' : 'no') . ', file: ' . ($filePersisted ? 'yes' : 'no') . ')') . "\n";
} else {
    echo "FAIL: Edit did not persist. API said success but file/API read shows old URL.\n";
    echo "  Expected URL: $apiTestUrl\n";
    echo "  API returned: " . ($apiItem2['url'] ?? 'null') . "\n";
    echo "  File has:     " . ($fileItem['url'] ?? 'null') . "\n";
    echo "\n  Debug info:\n";
    $debug = httpGet($debugUrl);
    if ($debug) {
        echo "  " . json_encode($debug, JSON_PRETTY_UNESCAPED_SLASHES) . "\n";
    }
    echo "\n  Possible cause: Web server runs from different directory than this script.\n";
    echo "  Fix: Run PHP server from project dir:\n";
    echo "    cd " . $projectDir . "\n";
    echo "    php -S localhost:8080\n";
    exit(1);
}

echo "\nAll tests passed.\n";
