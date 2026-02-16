<?php
$dataFile = __DIR__ . '/data.json';
$initialData = ['categories' => []];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $decoded = json_decode($json, true);
    if ($decoded) {
        if (isset($decoded['timeBlocks']) && !isset($decoded['events'])) {
            $decoded['events'] = $decoded['timeBlocks'];
            unset($decoded['timeBlocks']);
        }
        $initialData = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Developer Start Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&family=Orbitron:wght@400;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@300;400;500;600;700&family=VT323&family=Pixelify+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/chicagoflf" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/webaudiofont@3.0.4/npm/dist/WebAudioFontPlayer.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/webaudiofont@3.0.4/examples/MIDIFile.js"></script>
  <style>
    :root {
      --bg: #1a1630;
      --bg-alt: #2a2450;
      --content: #e0e0ff;
      --content-muted: #a0a0c0;
      --button-bg: #ff6600;
      --button-hover: #ff8833;
      --card-bg: #2a2450;
      --card-border: #4a4480;
      --bevel-light: #5a54a0;
      --bevel-dark: #1a1630;
    }

    /* Tron theme */
    html[data-theme="tron"] {
      --bg: #0a0e17;
      --bg-alt: #0d1520;
      --content: #00ffff;
      --content-muted: #00b8d4;
      --button-bg: #00ffff;
      --button-hover: #00e5ff;
      --button-fg: #0a0e17;
      --card-bg: rgba(0, 200, 255, 0.05);
      --card-border: #00ffff;
      --bevel-light: rgba(0, 255, 255, 0.3);
      --bevel-dark: #050810;
      --edit-btn-bg: #00d4ff;
      --edit-btn-fg: #0a0e17;
      --edit-btn-border: #00ffff;
      --edit-btn-hover: #00e5ff;
      --delete-btn-bg: #00d4ff;
      --delete-btn-fg: #0a0e17;
      --delete-btn-border: #00ffff;
      --delete-btn-hover: #00e5ff;
    }

    /* Tron Ares theme (red) */
    html[data-theme="tron-ares"] {
      --bg: #170a0a;
      --bg-alt: #200d0d;
      --content: #ff0040;
      --content-muted: #d40038;
      --button-bg: #ff0040;
      --button-hover: #ff3366;
      --button-fg: #170a0a;
      --card-bg: rgba(255, 0, 64, 0.05);
      --card-border: #ff0040;
      --bevel-light: rgba(255, 0, 64, 0.3);
      --bevel-dark: #100505;
      --edit-btn-bg: #ff0040;
      --edit-btn-fg: #170a0a;
      --edit-btn-border: #ff3366;
      --edit-btn-hover: #ff3366;
      --delete-btn-bg: #ff0040;
      --delete-btn-fg: #170a0a;
      --delete-btn-border: #ff3366;
      --delete-btn-hover: #ff3366;
    }

    /* Matrix theme */
    html[data-theme="matrix"] {
      --bg: #0d0d0d;
      --bg-alt: #0a0a0a;
      --content: #00ff41;
      --content-muted: #00cc34;
      --button-bg: #00ff41;
      --button-hover: #33ff66;
      --button-fg: #0d0d0d;
      --card-bg: rgba(0, 255, 65, 0.05);
      --card-border: #00ff41;
      --bevel-light: rgba(0, 255, 65, 0.2);
      --bevel-dark: #050505;
      --edit-btn-bg: #00ff41;
      --edit-btn-fg: #0d0d0d;
      --edit-btn-border: #33ff66;
      --edit-btn-hover: #33ff66;
      --delete-btn-bg: #00ff41;
      --delete-btn-fg: #0d0d0d;
      --delete-btn-border: #33ff66;
      --delete-btn-hover: #33ff66;
    }

    /* Sega Master System theme (8-bit) */
    html[data-theme="sms"] {
      --bg: #181830;
      --bg-alt: #282850;
      --content: #b8d4f0;
      --content-muted: #8098b8;
      --button-bg: #00aaff;
      --button-hover: #33bbff;
      --button-fg: #181830;
      --card-bg: #202048;
      --card-border: #4040a0;
      --bevel-light: #6060c0;
      --bevel-dark: #101030;
      --edit-btn-bg: #00aaff;
      --edit-btn-fg: #181830;
      --edit-btn-border: #33bbff;
      --edit-btn-hover: #33bbff;
      --delete-btn-bg: #0088cc;
      --delete-btn-fg: #181830;
      --delete-btn-border: #00aaff;
      --delete-btn-hover: #00aaff;
    }

    /* PlayStation 5 theme (ultra modern) */
    html[data-theme="ps5"] {
      --bg: #0c0c0c;
      --bg-alt: #121212;
      --content: #ffffff;
      --content-muted: #8e8e93;
      --button-bg: #006fcd;
      --button-hover: #0077e6;
      --button-fg: #ffffff;
      --card-bg: rgba(255, 255, 255, 0.04);
      --card-border: rgba(255, 255, 255, 0.12);
      --bevel-light: rgba(255, 255, 255, 0.08);
      --bevel-dark: #050505;
      --edit-btn-bg: #006fcd;
      --edit-btn-fg: #ffffff;
      --edit-btn-border: #0077e6;
      --edit-btn-hover: #0077e6;
      --delete-btn-bg: #004578;
      --delete-btn-fg: #ffffff;
      --delete-btn-border: #006fcd;
      --delete-btn-hover: #006fcd;
    }

    /* Original Game Boy theme */
    html[data-theme="gb"] {
      --bg: #9bbc0f;
      --bg-alt: #8bac0f;
      --content: #0f380f;
      --content-muted: #306230;
      --button-bg: #0f380f;
      --button-hover: #306230;
      --button-fg: #9bbc0f;
      --card-bg: #8bac0f;
      --card-border: #306230;
      --bevel-light: #9bbc0f;
      --bevel-dark: #0f380f;
      --edit-btn-bg: #0f380f;
      --edit-btn-fg: #9bbc0f;
      --edit-btn-border: #306230;
      --edit-btn-hover: #306230;
      --delete-btn-bg: #0f380f;
      --delete-btn-fg: #9bbc0f;
      --delete-btn-border: #306230;
      --delete-btn-hover: #306230;
    }

    /* Original Macintosh (1984) theme – 1-bit black and white */
    html[data-theme="macintosh"] {
      --bg: #ffffff;
      --bg-alt: #ffffff;
      --content: #000000;
      --content-muted: #000000;
      --button-bg: #000000;
      --button-hover: #000000;
      --button-fg: #ffffff;
      --card-bg: #ffffff;
      --card-border: #000000;
      --bevel-light: #ffffff;
      --bevel-dark: #000000;
      --edit-btn-bg: #000000;
      --edit-btn-fg: #ffffff;
      --edit-btn-border: #000000;
      --edit-btn-hover: #000000;
      --delete-btn-bg: #000000;
      --delete-btn-fg: #ffffff;
      --delete-btn-border: #000000;
      --delete-btn-hover: #000000;
    }

    /* MS-DOS theme – mid-90s window (gray chrome, black/white content, subtle color) */
    html[data-theme="msdos"] {
      --bg: #c0c0c0;
      --bg-alt: #a8a8a8;
      --content: #000000;
      --content-muted: #404040;
      --button-bg: #c0c0c0;
      --button-hover: #d4d0c8;
      --button-fg: #000000;
      --card-bg: #ffffff;
      --card-border: #808080;
      --bevel-light: #ffffff;
      --bevel-dark: #808080;
      --edit-btn-bg: #0000aa;
      --edit-btn-fg: #ffffff;
      --edit-btn-border: #000080;
      --edit-btn-hover: #0000aa;
      --delete-btn-bg: #c0c0c0;
      --delete-btn-fg: #000000;
      --delete-btn-border: #808080;
      --delete-btn-hover: #d4d0c8;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      min-height: 100vh;
      background: var(--bg);
      background-image: 
        repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,0.03) 2px, rgba(0,0,0,0.03) 4px),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 50%, var(--bg) 100%);
      color: var(--content);
      font-family: 'Silkscreen', monospace;
      font-size: 14px;
      transition: background 0.3s, color 0.3s;
    }

    html[data-theme="tron"] body {
      background-image: 
        linear-gradient(rgba(0, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 50%, var(--bg) 100%);
      background-size: 20px 20px, 20px 20px, 100% 100%;
    }
    html[data-theme="tron"] body,
    html[data-theme="tron"] *,
    html[data-theme="tron-ares"] body,
    html[data-theme="tron-ares"] * {
      font-family: 'JetBrains Mono', monospace;
    }
    html[data-theme="tron-ares"] body {
      background-image: 
        linear-gradient(rgba(255, 0, 64, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 0, 64, 0.04) 1px, transparent 1px),
        linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 50%, var(--bg) 100%);
      background-size: 20px 20px, 20px 20px, 100% 100%;
    }
    html[data-theme="matrix"] body,
    html[data-theme="matrix"] * {
      font-family: 'JetBrains Mono', monospace;
    }
    html[data-theme="matrix"] body {
      background-image: linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 100%);
      position: relative;
    }
    html[data-theme="matrix"] body::after {
      content: '';
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 9999;
      background: repeating-linear-gradient(
        0deg,
        transparent 0px,
        transparent 2px,
        rgba(0, 0, 0, 0.25) 2px,
        rgba(0, 0, 0, 0.25) 4px
      );
      background-size: 100% 4px;
    }
    html[data-theme="ps5"] body,
    html[data-theme="ps5"] * {
      font-family: 'Outfit', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="ps5"] body {
      background: linear-gradient(165deg, #0c0c0c 0%, #121212 40%, #0a0a0a 100%);
      background-attachment: fixed;
    }
    html[data-theme="macintosh"] body,
    html[data-theme="macintosh"] * {
      font-family: 'ChicagoFLF', Chicago, -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="macintosh"] body {
      background: #ffffff;
      background-image: none;
    }
    html[data-theme="msdos"] body,
    html[data-theme="msdos"] * {
      font-family: 'JetBrains Mono', 'Consolas', 'Courier New', monospace;
    }
    html[data-theme="msdos"] body {
      background: #c0c0c0;
      background-image: none;
    }
    .app { min-height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 2rem; }

    .sidebar { width: 100%; max-width: 900px; display: flex; flex-direction: column; min-height: calc(100vh - 4rem); }

    .clock {
      text-align: center;
      font-size: 3.5rem;
      font-weight: 700;
      letter-spacing: 0.15em;
      color: var(--content);
      margin-bottom: 1rem;
      font-variant-numeric: tabular-nums;
      font-family: 'Silkscreen', monospace;
      text-shadow: 2px 2px 0 var(--bevel-dark);
    }

    .day-bars {
      margin-bottom: 1.5rem;
    }
    .day-bar-wrap {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }
    .day-bar-wrap .edit-blocks-btn {
      display: none;
      padding: 0.25rem 0.5rem;
      font-size: 0.6rem;
      font-family: inherit;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      color: var(--content-muted);
      cursor: pointer;
    }
    .edit-mode .day-bar-wrap .edit-blocks-btn { display: inline-block; }
    .edit-blocks-btn:hover { color: var(--content); background: var(--card-border); }
    .day-bar {
      text-align: center;
      flex: 1;
      min-width: 200px;
    }
    .day-bar-label {
      font-size: 0.7rem;
      color: var(--content-muted);
      letter-spacing: 0.08em;
      margin-bottom: 0.5rem;
      font-family: 'Silkscreen', monospace;
      text-transform: uppercase;
    }
    .day-bar-track {
      height: 28px;
      display: flex;
      gap: 4px;
      padding: 4px;
      background: var(--bevel-dark);
      border: 3px solid var(--card-border);
      box-shadow: inset 2px 2px 0 var(--bevel-light), inset -2px -2px 0 var(--bevel-dark);
    }
    .day-bar-segment {
      flex: 1;
      min-width: 0;
      background: rgba(0, 0, 0, 0.5);
      transition: background 0.3s;
    }
    .day-bar-segment.filled {
      background: var(--button-bg);
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .theme-switcher {
      display: flex;
      align-items: center;
    }
    .midi-player-widget {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      padding: 0.25rem 0.4rem;
      font-size: 0.7rem;
      font-family: inherit;
    }
    .midi-player-widget .midi-btn,
    .midi-player-widget .midi-track-name {
      font-family: inherit;
    }
    .midi-player-widget .midi-btn {
      width: 1.5rem;
      height: 1.5rem;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      color: var(--content);
      cursor: pointer;
      font-size: 0.75rem;
      flex-shrink: 0;
    }
    .midi-player-widget .midi-btn:hover {
      background: var(--card-border);
      color: var(--bg);
    }
    .midi-player-widget .midi-btn:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }
    .midi-player-widget .midi-track-name {
      max-width: 8rem;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      color: var(--content-muted);
      font-size: 0.65rem;
    }
    .midi-player-modal .midi-track-name {
      max-width: 14rem;
      font-size: 0.8rem;
    }
    .midi-mode-group {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }
    .midi-mode-sep {
      color: var(--content-muted);
      font-size: 0.65rem;
      opacity: 0.6;
    }
    .midi-mode-btn .material-icons {
      font-size: 1rem;
      font-family: 'Material Icons' !important;
    }
    .midi-mode-btn {
      font-size: 0.85rem;
    }
    .midi-mode-btn.active,
    .midi-player-widget .midi-mode-btn.active {
      background: var(--button-bg);
      color: var(--button-fg, white);
      border-color: var(--button-bg);
    }
    .midi-mode-btn.active:hover {
      background: var(--button-hover);
      border-color: var(--button-hover);
      color: var(--button-fg, white);
    }

    .midi-progress-wrap {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .midi-progress-bar {
      flex: 1;
      min-width: 0;
      height: 12px;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      box-shadow: inset 1px 1px 0 var(--bevel-light), inset -1px -1px 0 var(--bevel-dark);
    }
    .midi-progress-bar:focus {
      outline: none;
      border-color: var(--button-bg);
    }
    .midi-progress-fill {
      height: 100%;
      width: 0%;
      background: var(--button-hover, var(--button-bg));
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2);
      pointer-events: none;
    }
    .midi-progress-bar:hover .midi-progress-fill {
      box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35), 0 0 8px var(--button-bg);
    }
    .midi-progress-time {
      font-size: 0.7rem;
      color: var(--content-muted);
      font-variant-numeric: tabular-nums;
      min-width: 6.5rem;
    }
    .midi-player-widget .midi-playlist-btn {
      padding: 0 0.25rem;
      font-size: 0.7rem;
    }
    .theme-select {
      padding: 0.35rem 0.6rem;
      padding-right: 1.75rem;
      font-size: 0.7rem;
      font-family: inherit;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      color: var(--content);
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%23888' stroke-width='2'%3E%3Cpath d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.4rem center;
      border-radius: 0;
      min-width: 8rem;
    }
    .theme-select:hover {
      border-color: var(--button-bg);
    }
    .theme-select:focus {
      outline: none;
      border-color: var(--button-bg);
      box-shadow: 0 0 0 2px var(--card-bg);
    }
    .theme-switcher-fixed .theme-select {
      min-width: 6.5rem;
      padding: 0.3rem 0.5rem;
      font-size: 0.65rem;
    }

    .charms-menu {
      position: fixed;
      bottom: 1rem;
      left: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
      align-items: stretch;
      z-index: 100;
    }
    .charms-btn,
    .edit-mode-btn,
    .screensaver-btn {
      width: 2.25rem;
      height: 2.25rem;
      min-width: 2.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--card-bg);
      border: 3px solid var(--card-border);
      color: var(--content-muted);
      cursor: pointer;
      font-size: 1rem;
      font-family: inherit;
      opacity: 0.7;
      box-shadow: 2px 2px 0 var(--bevel-dark), inset 1px 1px 0 var(--bevel-light);
      transition: opacity 0.15s, background 0.15s;
    }
    .charms-btn:hover,
    .edit-mode-btn:hover,
    .screensaver-btn:hover { opacity: 1; background: var(--card-border); }
    .edit-mode-btn.active { opacity: 1; background: var(--button-bg); border-color: var(--button-bg); color: white; box-shadow: 2px 2px 0 #994400; }

    .theme-switcher-charms {
      position: relative;
    }
    .theme-dropdown {
      position: absolute;
      bottom: 100%;
      left: 0;
      margin-bottom: 0.25rem;
      background-color: var(--bg-alt);
      border: 3px solid var(--card-border);
      box-shadow: 3px 3px 0 var(--bevel-dark), inset 1px 1px 0 var(--bevel-light);
      min-width: 8rem;
      max-height: 12rem;
      overflow-y: auto;
      display: none;
      z-index: 101;
      scrollbar-color: var(--card-border) var(--bevel-dark);
      scrollbar-width: thin;
    }
    .theme-dropdown::-webkit-scrollbar {
      width: 8px;
    }
    .theme-dropdown::-webkit-scrollbar-track {
      background: var(--bevel-dark);
    }
    .theme-dropdown::-webkit-scrollbar-thumb {
      background: var(--card-border);
      border: 2px solid var(--bevel-dark);
      border-radius: 2px;
    }
    .theme-dropdown::-webkit-scrollbar-thumb:hover {
      background: var(--button-bg);
    }
    .theme-dropdown.open { display: block; }
    .theme-dropdown-option {
      display: block;
      width: 100%;
      padding: 0.4rem 0.6rem;
      text-align: left;
      font-size: 0.75rem;
      font-family: inherit;
      background: none;
      border: none;
      color: var(--content);
      cursor: pointer;
    }
    .theme-dropdown-option:hover { background: var(--card-border); color: var(--bg); }

    .theme-charm-btn { border-color: var(--button-bg); color: var(--button-bg); }
    .theme-charm-btn:hover { background: var(--button-bg); color: var(--button-fg, white); }

    .music-charm-playing {
      color: var(--button-fg, #fff) !important;
      background: var(--button-bg) !important;
      border-color: var(--button-bg) !important;
      opacity: 1;
    }

    .fixed-buttons { display: none; }

    h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: var(--content); font-family: 'Silkscreen', monospace; letter-spacing: 0.05em; }

    section { margin-bottom: 2rem; }

    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0.75rem;
    }
    .section-title {
      font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 0.1em; color: var(--content-muted);
      font-family: 'Silkscreen', monospace;
    }
    .add-item-btn {
      display: none;
      background: var(--button-bg); color: var(--button-fg, white);
      padding: 0.3rem 0.6rem; font-size: 0.65rem;
      cursor: pointer;
      font-family: inherit;
      border: 2px solid var(--button-border, var(--button-bg));
      box-shadow: 2px 2px 0 var(--bevel-dark);
    }
    .add-item-btn:hover { background: var(--button-hover); }
    .edit-mode .add-item-btn { display: inline-block; }

    .add-category-row {
      margin-bottom: 1.5rem;
      display: none;
    }
    .edit-mode .add-category-row,
    .empty-categories .add-category-row { display: block; }
    .add-category-row .add-category-btn {
      display: inline-block;
      background: var(--button-bg);
      color: var(--button-fg, white);
      padding: 0.4rem 0.8rem;
      font-size: 0.75rem;
      cursor: pointer;
      font-family: inherit;
      border: 2px solid var(--button-border, var(--button-bg));
      box-shadow: 2px 2px 0 var(--bevel-dark);
    }
    .add-category-row .add-category-btn:hover { background: var(--button-hover); }
    .empty-state-msg {
      color: var(--content-muted);
      font-size: 0.85rem;
      margin-bottom: 0.5rem;
    }

    .links {
      display: flex;
      flex-wrap: nowrap;
      gap: 0.5rem;
      overflow-x: auto;
      overflow-y: hidden;
      scrollbar-width: none;
      -ms-overflow-style: none;
      padding-bottom: 0.25rem;
      scroll-snap-type: x mandatory;
    }
    .links::-webkit-scrollbar { display: none; }
    .link-card {
      flex-shrink: 0;
      flex: 0 0 calc((100% - 2rem) / 5);
      min-width: calc((100% - 2rem) / 5);
      scroll-snap-align: start;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: space-between;
      min-height: 0;
      aspect-ratio: 3/2;
      padding: 0.65rem;
      background: var(--card-bg);
      border: 3px solid var(--card-border);
      color: var(--content);
      font-size: 0.8rem;
      font-weight: 400;
      font-family: 'Silkscreen', monospace;
      text-align: left;
      box-shadow: inset 2px 2px 0 var(--bevel-light), inset -2px -2px 0 var(--bevel-dark), 3px 3px 0 var(--bevel-dark);
      transition: background 0.15s, box-shadow 0.15s;
    }
    .link-card:hover { background: #3a3470; box-shadow: inset 2px 2px 0 var(--bevel-light), inset -2px -2px 0 var(--bevel-dark), 2px 2px 0 var(--bevel-dark); }

    .edit-mode .link-card { cursor: grab; }
    .edit-mode .link-card:active { cursor: grabbing; }
    .link-card.sortable-ghost { opacity: 0.4; }

    .link-card-content { flex: 1; min-width: 0; }

    .link-actions {
      display: flex;
      gap: 0.2rem;
      margin-top: 0.35rem;
      width: 100%;
    }
    .edit-item-btn, .delete-item-btn {
      display: none;
      width: 1.5rem; height: 1.5rem;
      align-items: center; justify-content: center;
      border: 2px solid; cursor: pointer;
      font-size: 0.65rem; font-family: inherit;
      box-shadow: 1px 1px 0 var(--bevel-dark);
    }
    .edit-item-btn {
      border-color: var(--edit-btn-border, #2266bb);
      background: var(--edit-btn-bg, #3b82f6);
      color: var(--edit-btn-fg, white);
    }
    .edit-item-btn:hover { background: var(--edit-btn-hover, #2563eb); }
    .delete-item-btn {
      border-color: var(--delete-btn-border, #992222);
      background: var(--delete-btn-bg, #dc2626);
      color: var(--delete-btn-fg, white);
    }
    .delete-item-btn:hover { background: var(--delete-btn-hover, #b91c1c); }
    .edit-mode .edit-item-btn, .edit-mode .delete-item-btn { display: inline-flex; }

    .link-icon {
      display: inline-flex; align-items: center; justify-content: center;
      flex: 1; min-width: 0;
      height: 1.5rem;
      font-size: 0.65rem; text-decoration: none; transition: background 0.15s;
      font-family: 'Silkscreen', monospace;
      background: var(--button-bg); color: white;
      border: 2px solid #cc5500;
      box-shadow: 2px 2px 0 #994400;
    }
    .link-icon:hover { background: var(--button-hover); color: white; }

    .link-card--dev { border-left: 5px solid #00cc66; }
    .link-card--dev:hover { border-left-color: #66bb6a; }
    .link-card--nhs { border-left: 5px solid #0088ff; }
    .link-card--nhs:hover { border-left-color: #33aaff; }
    .link-card--private { border-left: 5px solid #ffaa00; }
    .link-card--private:hover { border-left-color: #ffcc33; }

    .link-card-content .link-title {
      display: -webkit-box;
      -webkit-line-clamp: 2; -webkit-box-orient: vertical;
      line-height: 1.25; min-height: 2.5em;
      overflow: hidden; text-overflow: ellipsis;
    }
    .link-card-content .link-subtitle {
      display: block; margin-top: 0.2rem; color: var(--content-muted);
      font-weight: 400; font-size: 0.75rem; line-height: 1.3; height: 1.3em;
      overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .link-card-content .link-subtitle:empty { visibility: hidden; }
    .modal-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.7);
      align-items: center; justify-content: center;
      z-index: 1000;
    }
    .modal-overlay.open { display: flex; }
    .modal {
      background: var(--bg-alt);
      border: 3px solid var(--card-border);
      box-shadow: inset 2px 2px 0 var(--bevel-light), 6px 6px 0 var(--bevel-dark);
      padding: 1.25rem;
      min-width: 320px;
    }
    .modal h3 { margin: 0 0 1rem 0; font-size: 1rem; font-family: inherit; }
    .modal label { display: block; margin-bottom: 0.25rem; font-size: 0.8rem; color: var(--content-muted); font-family: inherit; }
    .modal input, .modal select {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 0.75rem;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      color: var(--content);
      font-size: 0.9rem;
      font-family: inherit;
      box-shadow: inset 2px 2px 0 rgba(0,0,0,0.3);
    }
    .modal-actions {
      display: flex;
      gap: 0.5rem;
      justify-content: flex-end;
      margin-top: 1rem;
    }
    .modal-actions button {
      padding: 0.5rem 1rem;
      cursor: pointer;
      font-size: 0.8rem;
      font-family: inherit;
      border: 2px solid;
    }
    .modal-actions .btn-cancel {
      background: var(--card-bg);
      color: var(--content);
      border-color: var(--card-border);
      box-shadow: 2px 2px 0 var(--bevel-dark);
    }
    .modal .btn-save,
    .modal-actions .btn-save {
      background: var(--button-bg);
      color: white;
      border: 2px solid;
      border-color: var(--button-bg);
      box-shadow: 2px 2px 0 var(--bevel-dark);
    }
    .modal .btn-save:hover,
    .modal-actions .btn-save:hover { background: var(--button-hover); }

    .midi-add-row input,
    .midi-add-row button,
    .midi-add-row label,
    #musicControlsModal .modal h3,
    #musicControlsModal .time-block-row {
      font-family: inherit;
    }
    #midiPlaylistList .time-block-row {
      cursor: pointer;
    }
    #midiPlaylistList .time-block-row:hover {
      background: var(--card-border);
    }
    #musicControlsModal input::placeholder {
      color: var(--content-muted);
      opacity: 0.8;
    }
    .midi-add-row {
      align-items: flex-start;
    }
    .midi-add-row .btn-save {
      padding: 0.35rem 0.5rem;
      font-size: 0.7rem;
      line-height: 1;
      min-height: 0;
      box-shadow: 2px 2px 0 var(--bevel-dark);
    }

    .time-blocks-list { margin: 0.75rem 0; max-height: 200px; overflow-y: auto; }
    .time-block-row {
      display: flex; align-items: center; gap: 0.5rem;
      padding: 0.35rem 0; border-bottom: 1px solid var(--card-border);
      font-size: 0.8rem;
    }
    .time-block-row:last-child { border-bottom: none; }
    .time-block-row span { flex: 1; }
    .time-block-row .tb-edit, .time-block-row .tb-delete {
      padding: 0.15rem 0.35rem; font-size: 0.6rem; cursor: pointer;
      border: 2px solid; font-family: inherit;
    }
    .time-block-row .tb-edit {
      border-color: var(--edit-btn-border, #2266bb);
      background: var(--edit-btn-bg, #3b82f6);
      color: var(--edit-btn-fg, white);
    }
    .time-block-row .tb-edit:hover { background: var(--edit-btn-hover, #2563eb); }
    .time-block-row .tb-delete {
      border-color: var(--delete-btn-border, #992222);
      background: var(--delete-btn-bg, #dc2626);
      color: var(--delete-btn-fg, white);
    }
    .time-block-row .tb-delete:hover { background: var(--delete-btn-hover, #b91c1c); }

    .scratch-pad {
      flex: 1 1 0;
      min-height: 6rem;
      display: flex;
      flex-direction: column;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      border-radius: 4px;
      overflow: hidden;
      box-shadow: inset 1px 1px 0 rgba(0,0,0,0.3);
    }
    .scratch-pad-header {
      padding: 0.35rem 0.6rem;
      background: var(--card-border);
      color: var(--bg);
      font-size: 0.65rem;
      font-family: 'JetBrains Mono', monospace;
      letter-spacing: 0.05em;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
    }
    .scratch-pad-tabs {
      display: flex;
      gap: 0;
      align-items: stretch;
    }
    .scratch-pad-tab {
      padding: 0.2rem 0.5rem;
      font-size: 0.6rem;
      font-family: 'JetBrains Mono', monospace;
      background: var(--card-bg);
      color: var(--content-muted);
      border: 2px solid transparent;
      cursor: pointer;
    }
    .scratch-pad-tab:hover { color: var(--content); background: var(--bevel-light); }
    .scratch-pad-tab.active { background: var(--bg); color: var(--content); }
    .scratch-pad-header-actions { display: flex; align-items: center; gap: 0.25rem; margin-left: auto; }
    .scratch-pad-maximize-btn {
      padding: 0.2rem 0.5rem;
      font-size: 0.6rem;
      font-family: 'JetBrains Mono', monospace;
      background: var(--bg);
      color: var(--card-border);
      border: 2px solid var(--bg);
      cursor: pointer;
      flex-shrink: 0;
      margin-left: 0.25rem;
    }
    .scratch-pad-maximize-btn:hover { background: var(--content); color: var(--bg); }
    .scratch-pad-run-js-btn,
    .scratch-pad-stop-btn {
      padding: 0.2rem 0.5rem;
      font-size: 0.6rem;
      font-family: 'JetBrains Mono', monospace;
      border: 2px solid transparent;
      cursor: pointer;
      flex-shrink: 0;
    }
    .scratch-pad-run-js-btn {
      background: var(--bg);
      color: var(--card-border);
      border-color: var(--bg);
    }
    .scratch-pad-run-js-btn:hover { background: var(--content); color: var(--bg); }
    .scratch-pad-stop-btn {
      background: var(--bg);
      color: #c44;
      border-color: var(--bg);
    }
    .scratch-pad-stop-btn:hover { background: #c44; color: white; }
    .scratch-pad-title { opacity: 0.9; }
    .scratch-pad-body {
      flex: 1;
      width: 100%;
      min-height: 4rem;
      padding: 0.6rem;
      margin: 0;
      border: none;
      background: rgba(0,0,0,0.4);
      color: var(--content);
      font-size: 0.8rem;
      font-family: 'JetBrains Mono', monospace;
      resize: vertical;
      box-sizing: border-box;
      scrollbar-width: thin;
      scrollbar-color: var(--card-border) var(--bevel-dark);
    }
    .scratch-pad-body::-webkit-scrollbar { width: 10px; }
    .scratch-pad-body::-webkit-scrollbar-track { background: var(--bevel-dark); }
    .scratch-pad-body::-webkit-scrollbar-thumb { background: var(--card-border); border-radius: 2px; }
    .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: var(--bevel-light); }
    .scratch-pad-body::placeholder { color: var(--content-muted); opacity: 0.7; }
    .scratch-pad-body:focus { outline: none; background: rgba(0,0,0,0.5); }
    body.scratch-pad-maximized .clock,
    body.scratch-pad-maximized .day-bars,
    body.scratch-pad-maximized .sidebar-header,
    body.scratch-pad-maximized #categoriesContainer {
      display: none;
    }
    body.scratch-pad-maximized .scratch-pad {
      flex: 1 1 auto;
      min-height: calc(100vh - 4rem);
      display: flex;
      flex-direction: column;
    }
    body.scratch-pad-maximized .scratch-pad-body {
      flex: 1;
      min-height: 200px;
      resize: none;
    }
    body.scratch-pad-maximized .scratch-pad-output {
      max-height: 40vh;
    }

    html[data-theme="tron"] .clock {
      color: #00ffff;
      text-shadow: 0 0 10px #00ffff, 0 0 20px rgba(0, 255, 255, 0.5);
    }
    html[data-theme="tron"] .link-card {
      border-color: rgba(0, 255, 255, 0.4);
      box-shadow: inset 0 0 20px rgba(0, 255, 255, 0.05), 0 0 10px rgba(0, 255, 255, 0.1);
    }
    html[data-theme="tron"] .link-card:hover {
      box-shadow: inset 0 0 20px rgba(0, 255, 255, 0.1), 0 0 15px rgba(0, 255, 255, 0.2);
    }
    html[data-theme="tron"] .link-card--dev { border-left-color: #00ff88; box-shadow: 0 0 8px rgba(0, 255, 136, 0.3); }
    html[data-theme="tron"] .link-card--nhs { border-left-color: #00d4ff; box-shadow: 0 0 8px rgba(0, 212, 255, 0.3); }
    html[data-theme="tron"] .link-card--private { border-left-color: #ff00aa; box-shadow: 0 0 8px rgba(255, 0, 170, 0.3); }
    html[data-theme="tron"] .day-bar-track {
      border-color: #00ffff;
      box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.1), 0 0 5px rgba(0, 255, 255, 0.2);
    }
    html[data-theme="tron"] .day-bar-segment.filled {
      background: #00d4ff !important;
      box-shadow: 0 0 6px rgba(0, 212, 255, 0.6);
    }
    html[data-theme="tron"] .add-item-btn,
    html[data-theme="tron"] .add-category-row .add-category-btn,
    html[data-theme="tron"] .link-icon,
    html[data-theme="tron"] .modal .btn-save,
    html[data-theme="tron"] .modal-actions .btn-save {
      border-color: #00d4ff;
      box-shadow: 0 0 8px rgba(0, 212, 255, 0.4);
      color: #0a0e17;
    }
    html[data-theme="tron"] .add-item-btn:hover,
    html[data-theme="tron"] .add-category-row .add-category-btn:hover,
    html[data-theme="tron"] .link-icon:hover,
    html[data-theme="tron"] .modal .btn-save:hover,
    html[data-theme="tron"] .modal-actions .btn-save:hover {
      color: #0a0e17;
      box-shadow: 0 0 12px rgba(0, 212, 255, 0.6);
    }
    html[data-theme="tron"] .edit-mode-btn.active {
      box-shadow: 0 0 10px rgba(0, 212, 255, 0.6);
      color: #0a0e17;
    }
    html[data-theme="tron"] .theme-select {
      background-color: #0a0e17;
      box-shadow: 0 0 8px rgba(0, 255, 255, 0.2);
    }
    html[data-theme="tron"] .theme-select option { background: #0a0e17; color: #00ffff; }
    html[data-theme="tron"] .scratch-pad {
      border-color: #00ffff;
      box-shadow: inset 0 0 15px rgba(0, 255, 255, 0.08), 0 0 8px rgba(0, 255, 255, 0.15);
    }
    html[data-theme="tron"] .scratch-pad-header { background: #00ffff; color: #0a0e17; }
    html[data-theme="tron"] .scratch-pad-body {
      background: rgba(0, 0, 0, 0.6);
      color: #00ffff;
      caret-color: #00ffff;
    }
    html[data-theme="tron"] .scratch-pad-body { scrollbar-color: #00ffff #050810; }
    html[data-theme="tron"] .scratch-pad-body::-webkit-scrollbar-track { background: #050810; }
    html[data-theme="tron"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #00ffff; }
    html[data-theme="tron"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: #00e5ff; }
    html[data-theme="tron"] .scratch-pad-body::placeholder { color: rgba(0, 255, 255, 0.5); }
    html[data-theme="tron"] #musicControlsModal input::placeholder { color: rgba(0, 255, 255, 0.5); }
    html[data-theme="tron"] .scratch-pad-title::before { content: 'root@work: '; opacity: 0.7; }
    html[data-theme="tron"] .scratch-pad-tab { background: rgba(0,255,255,0.2); color: #0a0e17; }
    html[data-theme="tron"] .scratch-pad-tab:hover { background: rgba(0,255,255,0.35); color: #0a0e17; }
    html[data-theme="tron"] .scratch-pad-tab.active { background: #0a0e17; color: #00ffff; }
    html[data-theme="tron"] .scratch-pad-maximize-btn { background: #0a0e17; color: #00ffff; border-color: #00ffff; }
    html[data-theme="tron"] .scratch-pad-maximize-btn:hover { background: #00ffff; color: #0a0e17; }
    html[data-theme="tron"] .scratch-pad-stop-btn { color: #ff4466; background: #0a0e17; border-color: #ff4466; }
    html[data-theme="tron"] .scratch-pad-stop-btn:hover:not(:disabled) { background: #ff4466; color: #0a0e17; }

    /* Tron Ares theme overrides */
    html[data-theme="tron-ares"] .clock {
      color: #ff0040;
      text-shadow: 0 0 10px #ff0040, 0 0 20px rgba(255, 0, 64, 0.5);
    }
    html[data-theme="tron-ares"] .link-card {
      border-color: rgba(255, 0, 64, 0.4);
      box-shadow: inset 0 0 20px rgba(255, 0, 64, 0.05), 0 0 10px rgba(255, 0, 64, 0.1);
    }
    html[data-theme="tron-ares"] .link-card:hover {
      box-shadow: inset 0 0 20px rgba(255, 0, 64, 0.1), 0 0 15px rgba(255, 0, 64, 0.2);
    }
    html[data-theme="tron-ares"] .link-card--dev { border-left-color: #00ff88; box-shadow: 0 0 8px rgba(0, 255, 136, 0.3); }
    html[data-theme="tron-ares"] .link-card--nhs { border-left-color: #ff3366; box-shadow: 0 0 8px rgba(255, 51, 102, 0.3); }
    html[data-theme="tron-ares"] .link-card--private { border-left-color: #ff0066; box-shadow: 0 0 8px rgba(255, 0, 102, 0.3); }
    html[data-theme="tron-ares"] .day-bar-track {
      border-color: #ff0040;
      box-shadow: inset 0 0 10px rgba(255, 0, 64, 0.1), 0 0 5px rgba(255, 0, 64, 0.2);
    }
    html[data-theme="tron-ares"] .day-bar-segment.filled {
      background: #ff0040 !important;
      box-shadow: 0 0 6px rgba(255, 0, 64, 0.6);
    }
    html[data-theme="tron-ares"] .add-item-btn,
    html[data-theme="tron-ares"] .add-category-row .add-category-btn,
    html[data-theme="tron-ares"] .link-icon,
    html[data-theme="tron-ares"] .modal .btn-save,
    html[data-theme="tron-ares"] .modal-actions .btn-save {
      border-color: #ff0040;
      box-shadow: 0 0 8px rgba(255, 0, 64, 0.4);
      color: #170a0a;
    }
    html[data-theme="tron-ares"] .add-item-btn:hover,
    html[data-theme="tron-ares"] .add-category-row .add-category-btn:hover,
    html[data-theme="tron-ares"] .link-icon:hover,
    html[data-theme="tron-ares"] .modal .btn-save:hover,
    html[data-theme="tron-ares"] .modal-actions .btn-save:hover {
      color: #170a0a;
      box-shadow: 0 0 12px rgba(255, 0, 64, 0.6);
    }
    html[data-theme="tron-ares"] .edit-mode-btn.active {
      box-shadow: 0 0 10px rgba(255, 0, 64, 0.6);
      color: #170a0a;
    }
    html[data-theme="tron-ares"] .theme-select {
      background-color: #170a0a;
      box-shadow: 0 0 8px rgba(255, 0, 64, 0.2);
    }
    html[data-theme="tron-ares"] .theme-select option { background: #170a0a; color: #ff0040; }
    html[data-theme="tron-ares"] .scratch-pad {
      border-color: #ff0040;
      box-shadow: inset 0 0 15px rgba(255, 0, 64, 0.08), 0 0 8px rgba(255, 0, 64, 0.15);
    }
    html[data-theme="tron-ares"] .scratch-pad-header { background: #ff0040; color: #170a0a; }
    html[data-theme="tron-ares"] .scratch-pad-body {
      background: rgba(0, 0, 0, 0.6);
      color: #ff0040;
      caret-color: #ff0040;
    }
    html[data-theme="tron-ares"] .scratch-pad-body { scrollbar-color: #ff0040 #100505; }
    html[data-theme="tron-ares"] .scratch-pad-body::-webkit-scrollbar-track { background: #100505; }
    html[data-theme="tron-ares"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #ff0040; }
    html[data-theme="tron-ares"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: #ff3366; }
    html[data-theme="tron-ares"] .scratch-pad-body::placeholder { color: rgba(255, 0, 64, 0.5); }
    html[data-theme="tron-ares"] #musicControlsModal input::placeholder { color: rgba(255, 0, 64, 0.5); }
    html[data-theme="tron-ares"] .scratch-pad-title::before { content: 'root@ares: '; opacity: 0.7; }
    html[data-theme="tron-ares"] .scratch-pad-tab { background: rgba(255,0,64,0.2); color: #170a0a; }
    html[data-theme="tron-ares"] .scratch-pad-tab:hover { background: rgba(255,0,64,0.35); color: #170a0a; }
    html[data-theme="tron-ares"] .scratch-pad-tab.active { background: #170a0a; color: #ff0040; }

    /* Matrix theme overrides */
    html[data-theme="matrix"] .clock {
      color: #00ff41;
      text-shadow: 0 0 8px #00ff41;
    }
    html[data-theme="matrix"] .link-card {
      border-color: rgba(0, 255, 65, 0.4);
      box-shadow: 0 0 8px rgba(0, 255, 65, 0.1);
    }
    html[data-theme="matrix"] .link-card:hover {
      background: rgba(0, 255, 65, 0.12);
      box-shadow: 0 0 12px rgba(0, 255, 65, 0.2);
    }
    html[data-theme="matrix"] .day-bar-track { border-color: #00ff41; }
    html[data-theme="matrix"] .day-bar-segment.filled {
      background: #00ff41 !important;
      box-shadow: 0 0 4px #00ff41;
    }
    html[data-theme="matrix"] .add-item-btn,
    html[data-theme="matrix"] .add-category-row .add-category-btn,
    html[data-theme="matrix"] .link-icon,
    html[data-theme="matrix"] .modal .btn-save,
    html[data-theme="matrix"] .modal-actions .btn-save {
      border-color: #00ff41;
      box-shadow: 0 0 6px rgba(0, 255, 65, 0.4);
      color: #0d0d0d;
    }
    html[data-theme="matrix"] .edit-mode-btn.active {
      box-shadow: 0 0 8px rgba(0, 255, 65, 0.5);
      color: #0d0d0d;
    }
    html[data-theme="matrix"] .theme-select {
      background-color: #0d0d0d;
      box-shadow: 0 0 6px rgba(0, 255, 65, 0.3);
    }
    html[data-theme="matrix"] .theme-select option { background: #0d0d0d; color: #00ff41; }
    html[data-theme="matrix"] .scratch-pad { border-color: #00ff41; }
    html[data-theme="matrix"] .scratch-pad-header { background: #00ff41; color: #0d0d0d; }
    html[data-theme="matrix"] .scratch-pad-body { color: #00ff41; caret-color: #00ff41; scrollbar-color: #00ff41 #050505; }
    html[data-theme="matrix"] .scratch-pad-body::-webkit-scrollbar-track { background: #050505; }
    html[data-theme="matrix"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #00ff41; }
    html[data-theme="matrix"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: #33ff66; }
    html[data-theme="matrix"] .scratch-pad-body::placeholder { color: rgba(0, 255, 65, 0.5); }
    html[data-theme="matrix"] #musicControlsModal input::placeholder { color: rgba(0, 255, 65, 0.5); }
    html[data-theme="matrix"] .scratch-pad-title::before { content: '> '; opacity: 0.7; }
    html[data-theme="matrix"] .scratch-pad-tab { background: rgba(0,255,65,0.2); color: #0d0d0d; }
    html[data-theme="matrix"] .scratch-pad-tab:hover { background: rgba(0,255,65,0.35); color: #0d0d0d; }
    html[data-theme="matrix"] .scratch-pad-tab.active { background: #0d0d0d; color: #00ff41; }

    /* Game Boy theme overrides */
    html[data-theme="gb"] .link-card--dev { border-left-color: #306230; }
    html[data-theme="gb"] .link-card--nhs { border-left-color: #0f380f; }
    html[data-theme="gb"] .link-card--private { border-left-color: #506230; }
    html[data-theme="gb"] .link-card:hover {
      background: #9bbc0f;
    }
    html[data-theme="gb"] .day-bar-segment.filled {
      background: #306230 !important;
    }
    html[data-theme="gb"] .add-item-btn,
    html[data-theme="gb"] .add-category-row .add-category-btn,
    html[data-theme="gb"] .link-icon,
    html[data-theme="gb"] .modal .btn-save,
    html[data-theme="gb"] .modal-actions .btn-save {
      border-color: #0f380f;
      box-shadow: 2px 2px 0 #306230;
      color: #9bbc0f;
    }
    html[data-theme="gb"] .edit-mode-btn.active {
      box-shadow: 2px 2px 0 #306230;
      color: #9bbc0f;
    }
    html[data-theme="gb"] .theme-select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%230f380f' stroke-width='2'%3E%3Cpath d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
    }
    html[data-theme="gb"] .theme-select:hover,
    html[data-theme="gb"] .theme-select:focus { border-color: #0f380f; }
    html[data-theme="gb"] .scratch-pad-tab { background: #8bac0f; color: #0f380f; }
    html[data-theme="gb"] .scratch-pad-tab:hover { background: #9bbc0f; color: #0f380f; }
    html[data-theme="gb"] .scratch-pad-tab.active { background: #0f380f; color: #9bbc0f; }
    html[data-theme="gb"] .scratch-pad,
    html[data-theme="gb"] .scratch-pad * { font-family: 'Pixelify Sans', monospace; }
    html[data-theme="gb"] .midi-player-widget .midi-btn {
      background: #0f380f;
      color: #9bbc0f;
      border-color: #306230;
    }
    html[data-theme="gb"] .midi-player-widget .midi-btn:hover {
      background: #306230;
      color: #9bbc0f;
    }
    html[data-theme="gb"] .midi-player-widget .midi-track-name {
      color: #0f380f;
    }
    html[data-theme="gb"] .midi-player-widget .midi-mode-btn.active {
      background: #9bbc0f;
      color: #0f380f;
      border-color: #9bbc0f;
    }
    html[data-theme="gb"] .midi-player-widget .midi-mode-btn.active:hover {
      background: #8bac0f;
      border-color: #8bac0f;
      color: #0f380f;
    }
    html[data-theme="gb"] .midi-player-widget,
    html[data-theme="gb"] .midi-player-widget *,
    html[data-theme="gb"] #musicControlsModal .modal,
    html[data-theme="gb"] #musicControlsModal .modal * { font-family: 'Pixelify Sans', monospace; }

    /* Sega Master System theme overrides */
    html[data-theme="sms"] .link-card:hover {
      background: #282860;
    }
    html[data-theme="sms"] .day-bar-segment.filled {
      background: #00aaff !important;
    }
    html[data-theme="sms"] .add-item-btn,
    html[data-theme="sms"] .add-category-row .add-category-btn,
    html[data-theme="sms"] .link-icon,
    html[data-theme="sms"] .modal .btn-save,
    html[data-theme="sms"] .modal-actions .btn-save {
      border-color: #0088cc;
      box-shadow: 2px 2px 0 #004466;
      color: #181830;
    }
    html[data-theme="sms"] .edit-mode-btn.active {
      box-shadow: 2px 2px 0 #004466;
      color: #181830;
    }
    html[data-theme="sms"] .theme-select:hover,
    html[data-theme="sms"] .theme-select:focus { border-color: #00aaff; }
    html[data-theme="sms"] .scratch-pad-tab { background: #202048; color: #8098b8; }
    html[data-theme="sms"] .scratch-pad-tab:hover { background: #282850; color: #b8d4f0; }
    html[data-theme="sms"] .scratch-pad-tab.active { background: #181830; color: #b8d4f0; }
    html[data-theme="sms"] .scratch-pad,
    html[data-theme="sms"] .scratch-pad * { font-family: 'VT323', monospace; }
    html[data-theme="sms"] .midi-player-widget .midi-mode-btn.active {
      background: #00aaff;
      color: #181830;
      border-color: #00aaff;
    }
    html[data-theme="sms"] .midi-player-widget .midi-mode-btn.active:hover {
      background: #33bbff;
      border-color: #33bbff;
      color: #181830;
    }
    html[data-theme="sms"] .midi-player-widget,
    html[data-theme="sms"] .midi-player-widget *,
    html[data-theme="sms"] #musicControlsModal .modal,
    html[data-theme="sms"] #musicControlsModal .modal * { font-family: 'VT323', monospace; }

    /* Megadrive/16-bit theme scratch-pad font */
    html[data-theme="megadrive"] .scratch-pad,
    html[data-theme="megadrive"] .scratch-pad * { font-family: 'VT323', monospace; }
    html[data-theme="megadrive"] .midi-player-widget,
    html[data-theme="megadrive"] .midi-player-widget *,
    html[data-theme="megadrive"] #musicControlsModal .modal,
    html[data-theme="megadrive"] #musicControlsModal .modal * { font-family: 'VT323', monospace; }

    /* PlayStation 5 theme overrides */
    html[data-theme="ps5"] .clock {
      color: #ffffff;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-shadow: 0 0 40px rgba(0, 111, 205, 0.15);
    }
    html[data-theme="ps5"] .link-card {
      border-radius: 12px;
      border-width: 1px;
      border-color: rgba(255, 255, 255, 0.1);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    html[data-theme="ps5"] .link-card:hover {
      border-color: rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.05);
      transform: translateY(-1px);
    }
    html[data-theme="ps5"] .link-card--dev { border-left: 3px solid #00c853; }
    html[data-theme="ps5"] .link-card--nhs { border-left: 3px solid #006fcd; }
    html[data-theme="ps5"] .link-card--private { border-left: 3px solid #ffab00; }
    html[data-theme="ps5"] .day-bar-track {
      border-radius: 8px;
      border-width: 1px;
      border-color: rgba(255, 255, 255, 0.1);
      box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.3);
    }
    html[data-theme="ps5"] .day-bar-segment {
      border-radius: 4px;
    }
    html[data-theme="ps5"] .day-bar-segment.filled {
      background: linear-gradient(90deg, #006fcd, #0077e6) !important;
      box-shadow: 0 0 12px rgba(0, 111, 205, 0.4);
    }
    html[data-theme="ps5"] .add-item-btn,
    html[data-theme="ps5"] .link-icon,
    html[data-theme="ps5"] .modal .btn-save,
    html[data-theme="ps5"] .modal-actions .btn-save {
      border-radius: 8px;
      border: none;
      box-shadow: 0 2px 8px rgba(0, 111, 205, 0.3);
    }
    html[data-theme="ps5"] .add-item-btn:hover,
    html[data-theme="ps5"] .link-icon:hover,
    html[data-theme="ps5"] .modal .btn-save:hover,
    html[data-theme="ps5"] .modal-actions .btn-save:hover {
      box-shadow: 0 4px 16px rgba(0, 111, 205, 0.4);
    }
    html[data-theme="ps5"] .edit-mode-btn {
      border-radius: 50%;
      border-width: 2px;
    }
    html[data-theme="ps5"] .edit-mode-btn.active {
      background: #006fcd;
      border-color: #006fcd;
      box-shadow: 0 0 20px rgba(0, 111, 205, 0.5);
    }
    html[data-theme="ps5"] .theme-select {
      background-color: #121212;
      border-radius: 8px;
      border-width: 1px;
    }
    html[data-theme="ps5"] .theme-select option { background: #121212; color: #ffffff; }
    html[data-theme="ps5"] .theme-select:hover,
    html[data-theme="ps5"] .theme-select:focus {
      border-color: #006fcd;
      box-shadow: 0 0 12px rgba(0, 111, 205, 0.3);
    }
    html[data-theme="ps5"] .modal {
      border-radius: 16px;
      border-width: 1px;
      box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6);
    }
    html[data-theme="ps5"] .scratch-pad {
      border-radius: 12px;
      border-width: 1px;
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
    }
    html[data-theme="ps5"] .scratch-pad-header {
      background: rgba(255, 255, 255, 0.06);
      color: #ffffff;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    html[data-theme="ps5"] .scratch-pad-body {
      background: rgba(0, 0, 0, 0.2);
      scrollbar-color: rgba(255,255,255,0.3) rgba(255,255,255,0.06);
    }
    html[data-theme="ps5"] .scratch-pad-body::-webkit-scrollbar-track { background: rgba(255,255,255,0.06); }
    html[data-theme="ps5"] .scratch-pad-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }
    html[data-theme="ps5"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.45); }
    html[data-theme="ps5"] .scratch-pad-body::placeholder { color: rgba(255, 255, 255, 0.35); }
    html[data-theme="ps5"] #musicControlsModal input::placeholder { color: rgba(255, 255, 255, 0.35); }
    html[data-theme="ps5"] .scratch-pad-tab { background: rgba(255,255,255,0.08); color: #8e8e93; }
    html[data-theme="ps5"] .scratch-pad-tab:hover { background: rgba(255,255,255,0.12); color: #ffffff; }
    html[data-theme="ps5"] .scratch-pad-tab.active { background: rgba(255,255,255,0.15); color: #ffffff; }

    /* Original Macintosh (1984) component overrides */
    html[data-theme="macintosh"] .clock {
      color: #000000;
      text-shadow: none;
      letter-spacing: 0.08em;
    }
    html[data-theme="macintosh"] .link-card {
      border-radius: 8px;
      box-shadow: none;
      border: 2px solid #000000;
      background: #ffffff;
      color: #000000;
    }
    html[data-theme="macintosh"] .link-card:hover {
      background: #000000;
      color: #ffffff;
      box-shadow: none;
    }
    html[data-theme="macintosh"] .link-card:hover .link-subtitle { color: #ffffff; }
    html[data-theme="macintosh"] .link-card--dev,
    html[data-theme="macintosh"] .link-card--nhs,
    html[data-theme="macintosh"] .link-card--private { border-left: 4px solid #000000; }
    html[data-theme="macintosh"] .day-bar-track {
      border: 2px solid #000000;
      background: #ffffff;
      border-radius: 6px;
      box-shadow: none;
    }
    html[data-theme="macintosh"] .day-bar-segment.filled {
      background: #000000 !important;
      border-radius: 2px;
    }
    html[data-theme="macintosh"] .add-item-btn,
    html[data-theme="macintosh"] .add-category-row .add-category-btn,
    html[data-theme="macintosh"] .link-icon,
    html[data-theme="macintosh"] .modal .btn-save,
    html[data-theme="macintosh"] .modal-actions .btn-save {
      background: #000000;
      color: #ffffff;
      border-color: #000000;
      border-radius: 6px;
      box-shadow: none;
    }
    html[data-theme="macintosh"] .add-item-btn:hover,
    html[data-theme="macintosh"] .add-category-row .add-category-btn:hover,
    html[data-theme="macintosh"] .link-icon:hover,
    html[data-theme="macintosh"] .modal .btn-save:hover,
    html[data-theme="macintosh"] .modal-actions .btn-save:hover {
      background: #000000;
    }
    html[data-theme="macintosh"] .edit-mode-btn {
      border-radius: 6px;
      box-shadow: 1px 1px 0 #000000;
    }
    html[data-theme="macintosh"] .midi-player-widget {
      background: #ffffff;
      border-color: #000000;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-btn {
      background: #ffffff;
      color: #000000;
      border-color: #000000;
      border-radius: 6px;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-btn:hover {
      background: #000000;
      color: #ffffff;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-btn:disabled {
      opacity: 0.5;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-track-name {
      color: #000000;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-mode-btn.active {
      background: #000000;
      color: #ffffff;
      border-color: #000000;
    }
    html[data-theme="macintosh"] .midi-player-widget .midi-mode-btn.active:hover {
      background: #333333;
      border-color: #333333;
      color: #ffffff;
    }
    html[data-theme="macintosh"] .edit-mode-btn.active {
      background: #000000;
      border-color: #000000;
      color: #ffffff;
      box-shadow: 1px 1px 0 #000000;
    }
    html[data-theme="macintosh"] .theme-select {
      background: #ffffff;
      border: 2px solid #000000;
      color: #000000;
      border-radius: 6px;
    }
    html[data-theme="macintosh"] .theme-select option { background: #ffffff; color: #000000; }
    html[data-theme="macintosh"] .theme-select:hover,
    html[data-theme="macintosh"] .theme-select:focus { border-color: #000000; }
    html[data-theme="macintosh"] .modal {
      border-radius: 10px;
      border: 2px solid #000000;
      background: #ffffff;
      box-shadow: 2px 2px 0 #000000;
    }
    html[data-theme="macintosh"] .scratch-pad {
      border-radius: 8px;
      border: 2px solid #000000;
      background: #ffffff;
    }
    html[data-theme="macintosh"] .scratch-pad-header {
      background: #ffffff;
      color: #000000;
      border-bottom: 1px solid #000000;
    }
    html[data-theme="macintosh"] .scratch-pad-body {
      background: #ffffff;
      color: #000000;
      caret-color: #000000;
    }
    html[data-theme="macintosh"] .scratch-pad-body::placeholder { color: #000000; }
    html[data-theme="macintosh"] #musicControlsModal input::placeholder { color: rgba(255, 255, 255, 0.6); }
    html[data-theme="macintosh"] .scratch-pad-title::before { content: 'NotePad: '; opacity: 1; }
    html[data-theme="macintosh"] .scratch-pad-tab {
      background: #ffffff;
      color: #000000;
      border-radius: 4px;
      border: 1px solid #000000;
    }
    html[data-theme="macintosh"] .scratch-pad-tab:hover { background: #000000; color: #ffffff; }
    html[data-theme="macintosh"] .scratch-pad-tab.active { background: #000000; color: #ffffff; font-weight: 700; }
    html[data-theme="macintosh"] .scratch-pad-maximize-btn,
    html[data-theme="macintosh"] .scratch-pad-stop-btn {
      background: #000000;
      color: #ffffff;
      border-color: #000000;
      border-radius: 4px;
    }
    html[data-theme="macintosh"] .scratch-pad-body { scrollbar-color: #000000 #ffffff; }
    html[data-theme="macintosh"] .section-title { color: #000000; }
    html[data-theme="macintosh"] .day-bar-segment {
      background: #ffffff;
      border-radius: 2px;
    }

    /* MS-DOS theme overrides – window chrome + black/white content, subtle color */
    html[data-theme="msdos"] .clock {
      color: #000000;
      text-shadow: 1px 1px 0 #ffffff;
    }
    html[data-theme="msdos"] .link-card {
      background: #ffffff;
      border: 2px solid #808080;
      box-shadow: 1px 1px 0 #ffffff inset, -1px -1px 0 #404040 inset, 2px 2px 0 #404040;
    }
    html[data-theme="msdos"] .link-card:hover {
      background: #f0f0f0;
      box-shadow: 1px 1px 0 #ffffff inset, -1px -1px 0 #404040 inset, 1px 1px 0 #404040;
    }
    html[data-theme="msdos"] .link-card--dev { border-left: 4px solid #00a000; }
    html[data-theme="msdos"] .link-card--nhs { border-left: 4px solid #0000aa; }
    html[data-theme="msdos"] .link-card--private { border-left: 4px solid #aa5500; }
    html[data-theme="msdos"] .day-bar-track {
      background: #c0c0c0;
      border: 2px solid #808080;
      box-shadow: 1px 1px 0 #ffffff inset, -1px -1px 0 #404040 inset;
    }
    html[data-theme="msdos"] .day-bar-segment.filled {
      background: #0000aa;
    }
    html[data-theme="msdos"] .add-item-btn,
    html[data-theme="msdos"] .link-icon,
    html[data-theme="msdos"] .modal .btn-save,
    html[data-theme="msdos"] .modal-actions .btn-save {
      background: #c0c0c0;
      color: #000000;
      border: 2px solid #808080;
      box-shadow: 1px 1px 0 #ffffff, -1px -1px 0 #404040;
    }
    html[data-theme="msdos"] .add-item-btn:hover,
    html[data-theme="msdos"] .link-icon:hover,
    html[data-theme="msdos"] .modal .btn-save:hover,
    html[data-theme="msdos"] .modal-actions .btn-save:hover {
      background: #d4d0c8;
    }
    html[data-theme="msdos"] .edit-mode-btn.active {
      background: #0000aa;
      border-color: #0000aa;
      color: #ffffff;
    }
    html[data-theme="msdos"] .midi-player-widget .midi-mode-btn.active {
      background: #0000aa;
      color: #ffffff;
      border-color: #0000aa;
    }
    html[data-theme="msdos"] .midi-player-widget .midi-mode-btn.active:hover {
      background: #0000cc;
      border-color: #0000cc;
      color: #ffffff;
    }
    html[data-theme="msdos"] .theme-select {
      background: #ffffff;
      border: 2px solid #808080;
      color: #000000;
    }
    html[data-theme="msdos"] .theme-select option { background: #ffffff; color: #000000; }
    html[data-theme="msdos"] .theme-select:hover,
    html[data-theme="msdos"] .theme-select:focus { border-color: #0000aa; }
    /* Scratch pad = MS-DOS window: gray title bar, black interior, white text, green prompt accent */
    html[data-theme="msdos"] .scratch-pad {
      border: 2px solid #808080;
      box-shadow: 1px 1px 0 #ffffff, -1px -1px 0 #404040, 2px 2px 4px rgba(0,0,0,0.3);
    }
    html[data-theme="msdos"] .scratch-pad-header {
      background: linear-gradient(180deg, #000080 0%, #1084d0 100%);
      color: #ffffff;
    }
    html[data-theme="msdos"] .scratch-pad-body {
      background: #000000;
      color: #c0c0c0;
      caret-color: #c0c0c0;
    }
    html[data-theme="msdos"] .scratch-pad-body { scrollbar-color: #404040 #000000; }
    html[data-theme="msdos"] .scratch-pad-body::-webkit-scrollbar-track { background: #000000; }
    html[data-theme="msdos"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #404040; }
    html[data-theme="msdos"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: #808080; }
    html[data-theme="msdos"] .scratch-pad-body::placeholder { color: rgba(192, 192, 192, 0.5); }
    html[data-theme="msdos"] #musicControlsModal input::placeholder { color: rgba(192, 192, 192, 0.5); }
    html[data-theme="msdos"] .scratch-pad-title::before { content: 'C:\\> '; color: #00aa00; opacity: 1; }
    html[data-theme="msdos"] .scratch-pad-tab {
      background: rgba(255,255,255,0.2);
      color: #ffffff;
      border: 1px solid rgba(255,255,255,0.3);
    }
    html[data-theme="msdos"] .scratch-pad-tab:hover { background: rgba(255,255,255,0.3); color: #ffffff; }
    html[data-theme="msdos"] .scratch-pad-tab.active {
      background: rgba(255,255,255,0.4);
      color: #ffffff;
      border-color: #ffffff;
    }
    html[data-theme="msdos"] .scratch-pad-run-js-btn,
    html[data-theme="msdos"] .scratch-pad-maximize-btn {
      background: transparent;
      color: #ffffff;
      border: 1px solid rgba(255,255,255,0.5);
    }
    html[data-theme="msdos"] .scratch-pad-run-js-btn:hover,
    html[data-theme="msdos"] .scratch-pad-maximize-btn:hover {
      background: rgba(255,255,255,0.2);
      color: #ffffff;
    }
    html[data-theme="msdos"] .scratch-pad-stop-btn {
      color: #ff8080;
      background: transparent;
      border: 1px solid rgba(255,255,255,0.5);
    }
    html[data-theme="msdos"] .scratch-pad-stop-btn:hover:not(:disabled) {
      background: rgba(255, 0, 0, 0.3);
      color: #ffffff;
    }
    html[data-theme="msdos"] .section-title { color: #404040; }
    html[data-theme="msdos"] .day-bar-label { color: #404040; }
    html[data-theme="msdos"] .modal {
      background: #c0c0c0;
      border: 2px solid #808080;
      box-shadow: 2px 2px 0 #404040, 1px 1px 0 #ffffff inset;
    }
    html[data-theme="msdos"] .modal h3,
    html[data-theme="msdos"] .modal label { color: #000000; }
    html[data-theme="msdos"] .modal input,
    html[data-theme="msdos"] .modal select {
      background: #ffffff;
      border: 2px solid #808080;
      color: #000000;
    }
    html[data-theme="msdos"] .modal-actions .btn-cancel {
      background: #c0c0c0;
      color: #000000;
      border: 2px solid #808080;
      box-shadow: 1px 1px 0 #ffffff, -1px -1px 0 #404040;
    }

    /* Mac-style zoom animation (Visit link) */
    :root {
      --visit-zoom-duration: var(--scratch-maximize-duration);
      --visit-zoom-easing: var(--scratch-maximize-easing);
    }
    .visit-zoom-overlay {
      position: fixed;
      inset: 0;
      z-index: 9999;
      pointer-events: none;
    }
    .visit-zoom-box {
      position: fixed;
      background: transparent;
      border: 2px solid var(--card-border);
      box-shadow: 0 0 0 1px var(--bevel-light);
      will-change: left, top, width, height;
    }
    .visit-zoom-box.zoom-done {
      pointer-events: auto;
    }

    /* Screensaver mode */
    .screensaver-overlay {
      position: fixed;
      inset: 0;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transition: opacity 0.8s ease, visibility 0.8s ease;
    }
    .screensaver-overlay.active {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }
    .screensaver-mystify {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      opacity: 0.25;
      background: transparent;
    }
    .screensaver-mystify[data-retro] {
      image-rendering: pixelated;
      image-rendering: crisp-edges;
    }
    .screensaver-content {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.5rem;
      padding: 2rem;
    }
    .screensaver-clock {
      font-size: 4.5rem;
      font-weight: 700;
      letter-spacing: 0.2em;
      color: var(--content);
      font-variant-numeric: tabular-nums;
      font-family: 'Silkscreen', monospace;
      text-shadow: 2px 2px 0 var(--bevel-dark);
      text-align: center;
      transition: color 0.3s, text-shadow 0.3s;
    }
    html[data-theme="tron"] .screensaver-clock {
      color: #00ffff;
      text-shadow: 0 0 15px #00ffff, 0 0 30px rgba(0, 255, 255, 0.5);
    }
    html[data-theme="tron-ares"] .screensaver-clock {
      color: #ff0040;
      text-shadow: 0 0 15px #ff0040, 0 0 30px rgba(255, 0, 64, 0.5);
    }
    html[data-theme="matrix"] .screensaver-clock {
      color: #00ff41;
      text-shadow: 0 0 10px #00ff41;
    }
    html[data-theme="ps5"] .screensaver-clock {
      color: #ffffff;
      text-shadow: 0 0 40px rgba(0, 111, 205, 0.2);
    }
    html[data-theme="macintosh"] .screensaver-clock {
      color: #000000;
      text-shadow: none;
    }
    html[data-theme="msdos"] .screensaver-clock {
      color: #000000;
      text-shadow: 1px 1px 0 #ffffff;
    }
    .screensaver-day-bars {
      min-width: 280px;
      max-width: 90vw;
    }
    .screensaver-day-bars .day-bar-label {
      font-size: 0.7rem;
      color: var(--content-muted);
      letter-spacing: 0.08em;
      margin-bottom: 0.5rem;
      font-family: 'Silkscreen', monospace;
      text-transform: uppercase;
      text-align: center;
    }
    .screensaver-day-bars .day-bar-track {
      height: 28px;
      display: flex;
      gap: 4px;
      padding: 4px;
      background: var(--bevel-dark);
      border: 3px solid var(--card-border);
      box-shadow: inset 2px 2px 0 var(--bevel-light), inset -2px -2px 0 var(--bevel-dark);
    }
    .screensaver-day-bars .day-bar-segment {
      flex: 1;
      min-width: 0;
      background: rgba(0, 0, 0, 0.5);
      transition: background 0.3s;
    }
    .screensaver-midi-track {
      font-size: 0.85rem;
      color: var(--content-muted);
      font-family: 'Silkscreen', monospace;
      letter-spacing: 0.05em;
      text-align: center;
      min-height: 1.2em;
    }
    html[data-theme="tron"] .screensaver-midi-track { color: rgba(0, 255, 255, 0.7); }
    html[data-theme="tron-ares"] .screensaver-midi-track { color: rgba(255, 0, 64, 0.7); }
    html[data-theme="matrix"] .screensaver-midi-track { color: rgba(0, 255, 65, 0.7); }
    html[data-theme="ps5"] .screensaver-midi-track { color: rgba(255, 255, 255, 0.6); }
    html[data-theme="macintosh"] .screensaver-midi-track { color: #000000; }
    html[data-theme="msdos"] .screensaver-midi-track { color: #404040; }
    html[data-theme="tron"] .screensaver-day-bars .day-bar-track {
      border-color: #00ffff;
      box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.1), 0 0 5px rgba(0, 255, 255, 0.2);
    }
    html[data-theme="tron"] .screensaver-day-bars .day-bar-segment.filled {
      background: #00d4ff !important;
      box-shadow: 0 0 6px rgba(0, 212, 255, 0.6);
    }
    html[data-theme="tron-ares"] .screensaver-day-bars .day-bar-track {
      border-color: #ff0040;
      box-shadow: inset 0 0 10px rgba(255, 0, 64, 0.1), 0 0 5px rgba(255, 0, 64, 0.2);
    }
    html[data-theme="tron-ares"] .screensaver-day-bars .day-bar-segment.filled {
      background: #ff0040 !important;
      box-shadow: 0 0 6px rgba(255, 0, 64, 0.6);
    }
    html[data-theme="matrix"] .screensaver-day-bars .day-bar-track { border-color: #00ff41; }
    html[data-theme="matrix"] .screensaver-day-bars .day-bar-segment.filled {
      background: #00ff41 !important;
      box-shadow: 0 0 4px #00ff41;
    }
    html[data-theme="ps5"] .screensaver-day-bars .day-bar-track {
      border-radius: 8px;
      border-color: rgba(255, 255, 255, 0.15);
    }
    html[data-theme="ps5"] .screensaver-day-bars .day-bar-segment.filled {
      background: linear-gradient(90deg, #006fcd, #0077e6) !important;
      border-radius: 4px;
    }

    /* Fade out main content when screensaver activates */
    .sidebar-header,
    #categoriesContainer,
    .scratch-pad,
    .fixed-buttons {
      transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    body.screensaver-active .sidebar-header,
    body.screensaver-active #categoriesContainer,
    body.screensaver-active .scratch-pad,
    body.screensaver-active .charms-menu {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
    }
    body.screensaver-active .clock,
    body.screensaver-active .day-bars {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transition: opacity 0.6s ease, visibility 0.6s ease;
    }
  </style>
</head>
<body>
  <div class="app" id="app">
    <aside class="sidebar" id="sidebar">
      <div class="clock" id="clock"></div>
      <div class="day-bars" id="dayBars"></div>
      <div class="sidebar-header">
        <h1 id="appTitle">Developer Start Page</h1>
      </div>
      <div id="categoriesContainer"></div>
      <div class="scratch-pad" id="scratchPad">
        <div class="scratch-pad-header">
          <span class="scratch-pad-tabs">
            <button class="scratch-pad-tab active" type="button" id="scratchPadTextTab" data-tab="text">Text</button>
            <button class="scratch-pad-tab" type="button" id="scratchPadBasicTab" data-tab="basic">Basic</button>
            <button class="scratch-pad-tab" type="button" id="scratchPadJsTab" data-tab="javascript">JavaScript</button>
          </span>
          <span class="scratch-pad-header-actions">
            <button class="scratch-pad-run-js-btn" type="button" id="scratchPadRunJsBtn" title="Run JavaScript" style="display:none">RUN</button>
            <button class="scratch-pad-stop-btn" type="button" id="scratchPadStopBtn" title="Stop execution" style="display:none">STOP</button>
            <button class="scratch-pad-maximize-btn" type="button" id="scratchPadMaximizeBtn" title="Full screen">⛶</button>
          </span>
        </div>
        <textarea class="scratch-pad-body" id="scratchPadText" placeholder="Text notes..." rows="4"></textarea>
      </div>
    </aside>
    <nav class="charms-menu">
      <button class="charms-btn" id="musicCharmBtn" type="button" title="Music controls" aria-label="Music controls">♪</button>
      <button class="screensaver-btn" id="screensaverBtn" type="button" title="Screensaver">◐</button>
      <button class="edit-mode-btn" id="editModeBtn" type="button" title="Edit">✎</button>
      <div class="theme-switcher-charms">
        <button class="charms-btn theme-charm-btn" id="themeCharmBtn" type="button" title="Theme" aria-label="Theme">&#9881;</button>
        <div class="theme-dropdown" id="themeDropdown">
          <button class="theme-dropdown-option" data-theme="megadrive">16-bit</button>
          <button class="theme-dropdown-option" data-theme="tron">Tron</button>
          <button class="theme-dropdown-option" data-theme="tron-ares">Ares</button>
          <button class="theme-dropdown-option" data-theme="matrix">Matrix</button>
          <button class="theme-dropdown-option" data-theme="sms">SMS</button>
          <button class="theme-dropdown-option" data-theme="gb">GB</button>
          <button class="theme-dropdown-option" data-theme="ps5">PS5</button>
          <button class="theme-dropdown-option" data-theme="macintosh">Macintosh</button>
          <button class="theme-dropdown-option" data-theme="msdos">MS-DOS</button>
        </div>
        <select class="theme-select" id="themeSelect" aria-label="Select theme" style="position:absolute;opacity:0;pointer-events:none;width:0;height:0">
          <option value="megadrive">16-bit</option>
          <option value="tron">Tron</option>
          <option value="tron-ares">Ares</option>
          <option value="matrix">Matrix</option>
          <option value="sms">SMS</option>
          <option value="gb">GB</option>
          <option value="ps5">PS5</option>
          <option value="macintosh">Macintosh</option>
          <option value="msdos">MS-DOS</option>
        </select>
      </div>
    </nav>
  </div>

  <div class="screensaver-overlay" id="screensaverOverlay" aria-hidden="true">
    <canvas class="screensaver-mystify" id="screensaverMystify"></canvas>
    <div class="screensaver-content">
      <div class="screensaver-clock" id="screensaverClock"></div>
      <div class="screensaver-day-bars" id="screensaverDayBars"></div>
      <div class="screensaver-midi-track" id="screensaverMidiTrack" aria-live="polite"></div>
    </div>
  </div>

  <div class="modal-overlay" id="timeBlocksModal">
    <div class="modal">
      <h3>Daily Events</h3>
      <div class="time-blocks-list" id="timeBlocksList"></div>
      <div class="modal-actions" style="margin-top: 0.5rem;">
        <button class="btn-save" type="button" id="addTimeBlockBtn">+ Add Event</button>
        <button class="btn-cancel" type="button" id="closeTimeBlocksBtn">Close</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="timeBlockFormModal">
    <div class="modal">
      <form id="timeBlockForm" novalidate>
        <h3 id="timeBlockFormTitle">Add Event</h3>
        <input type="hidden" id="tbFormId">
        <label>Label</label>
        <input type="text" id="tbFormLabel" placeholder="e.g. Lunch" required>
        <label>Time (HH:MM, 00:00–24:00)</label>
        <input type="text" id="tbFormTime" placeholder="11:00" pattern="[0-9]{1,2}:[0-5][0-9]" required>
        <div class="modal-actions">
          <button class="btn-cancel" type="button" id="tbFormCancelBtn">Cancel</button>
          <button class="btn-save" type="submit" id="tbFormSaveBtn">Save</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="categoryModal">
    <div class="modal">
      <form id="categoryForm" novalidate>
        <h3 id="categoryModalTitle">Add Category</h3>
        <label>Title</label>
        <input type="text" id="categoryModalTitleInput" placeholder="e.g. Dev Environment" required>
        <div class="modal-actions">
          <button class="btn-cancel" type="button" id="categoryModalCancelBtn">Cancel</button>
          <button class="btn-save" type="submit" id="categoryModalSaveBtn">Save</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="musicControlsModal">
    <div class="modal">
      <h3>Music Controls</h3>
      <div class="midi-player-widget midi-player-modal" id="midiPlayerWidget">
        <button class="midi-btn" id="midiPrevBtn" type="button" title="Previous" aria-label="Previous">⏮</button>
        <button class="midi-btn" id="midiPlayBtn" type="button" title="Play" aria-label="Play">▶</button>
        <button class="midi-btn" id="midiPauseBtn" type="button" title="Pause" aria-label="Pause" style="display:none">⏸</button>
        <button class="midi-btn" id="midiNextBtn" type="button" title="Next" aria-label="Next">⏭</button>
        <span class="midi-track-name" id="midiTrackName">—</span>
        <div class="midi-mode-group">
          <span class="midi-mode-sep" aria-hidden="true">|</span>
          <button class="midi-btn midi-mode-btn" id="midiShuffleBtn" type="button" title="Shuffle" aria-label="Shuffle" aria-pressed="false"><span class="material-icons">shuffle</span></button>
          <button class="midi-btn midi-mode-btn" id="midiRepeatOneBtn" type="button" title="Repeat current song" aria-label="Repeat one" aria-pressed="false"><span class="material-icons">repeat_one</span></button>
          <button class="midi-btn midi-mode-btn" id="midiRepeatAllBtn" type="button" title="Repeat playlist" aria-label="Repeat all" aria-pressed="false"><span class="material-icons">repeat</span></button>
        </div>
      </div>
      <div class="midi-progress-wrap" style="margin-top:0.5rem">
        <div class="midi-progress-bar" id="midiProgressBar" role="slider" aria-label="Track position" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0" title="Click to seek">
          <div class="midi-progress-fill" id="midiProgressFill"></div>
        </div>
        <span class="midi-progress-time" id="midiProgressTime">0:00 / 0:00</span>
      </div>
      <div class="music-modal-playlist" style="margin-top:1rem">
        <p class="empty-state-msg" id="midiPlaylistEmpty" style="display:none">No tracks. Add a MIDI file via URL or upload.</p>
        <div class="midi-add-row" style="margin-bottom:0.75rem;display:flex;gap:0.5rem;flex-wrap:wrap">
          <input type="text" id="midiUrlInput" placeholder="MIDI URL or path (e.g. midi/song.mid)" style="flex:1;min-width:180px;padding:0.4rem;font-size:0.8rem;background:var(--bevel-dark);border:2px solid var(--card-border);color:var(--content)">
          <input type="text" id="midiNameInput" placeholder="Track name (optional)" style="width:120px;padding:0.4rem;font-size:0.8rem;background:var(--bevel-dark);border:2px solid var(--card-border);color:var(--content)">
          <button class="btn-save" type="button" id="midiAddUrlBtn" style="padding:0.4rem 0.6rem;font-size:0.75rem">Add URL</button>
          <label style="display:flex;align-items:center;gap:0.35rem;cursor:pointer;font-size:0.75rem">
            <input type="file" id="midiFileInput" accept=".mid,.midi" style="display:none">
            <span class="link-icon" style="padding:0.35rem 0.5rem;font-size:0.7rem">Upload</span>
          </label>
        </div>
        <div class="time-blocks-list" id="midiPlaylistList" style="max-height:200px;overflow-y:auto"></div>
      </div>
      <div class="modal-actions" style="margin-top:0.5rem">
        <button class="btn-cancel" type="button" id="musicModalCloseBtn">Close</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="itemModal">
    <div class="modal">
      <form id="itemForm" novalidate>
        <h3 id="modalTitle">Add Item</h3>
        <input type="hidden" id="modalItemId">
        <input type="hidden" id="modalCategoryId">
        <label>Title</label>
        <input type="text" id="modalItemTitle" placeholder="Item title" required>
        <label>Subtitle</label>
        <input type="text" id="modalItemSubtitle" placeholder="Optional subtitle">
        <label>URL</label>
        <input type="url" id="modalItemUrl" placeholder="https://..." required>
        <label>Color</label>
        <select id="modalItemColor">
          <option value="">None</option>
          <option value="dev">Dev (green)</option>
          <option value="nhs">NHS (blue)</option>
          <option value="private">Private (amber)</option>
        </select>
        <div class="modal-actions">
          <button class="btn-cancel" type="button" id="modalCancelBtn">Cancel</button>
          <button class="btn-save" type="submit" id="modalSaveBtn">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  (function() {
    const app = document.getElementById('app');
    const html = document.documentElement;

    function escapeHtml(s) {
      const div = document.createElement('div');
      div.textContent = s == null ? '' : s;
      return div.innerHTML;
    }
    function toTitleCase(s) {
      if (s == null || typeof s !== 'string') return '';
      return s.replace(/\b\w/g, c => c.toUpperCase());
    }

    var THEME_TITLES = {
      megadrive: 'GAME SELECT',
      tron: 'root@work:~$',
      'tron-ares': 'root@work:~$',
      matrix: '> SYSTEM ONLINE',
      sms: 'INSERT CART',
      gb: 'NINTENDO',
      ps5: 'PlayStation',
      macintosh: 'Macintosh'
    };
    function updateTitle(theme) {
      var el = document.getElementById('appTitle');
      if (el) el.textContent = THEME_TITLES[theme] || 'Developer Start Page';
    }

    var themeSelect = document.getElementById('themeSelect');
    (function initTheme() {
      var saved = localStorage.getItem('devStartPageTheme') || 'megadrive';
      if (saved === 'vectrex') { saved = 'matrix'; localStorage.setItem('devStartPageTheme', saved); }
      if (saved === 'mother' || saved === 'nostromo') { saved = 'matrix'; localStorage.setItem('devStartPageTheme', 'matrix'); }
      html.setAttribute('data-theme', saved);
      if (themeSelect) themeSelect.value = saved;
      updateTitle(saved);
    })();

    if (themeSelect) {
      themeSelect.addEventListener('change', function() {
        var theme = this.value;
        html.setAttribute('data-theme', theme);
        localStorage.setItem('devStartPageTheme', theme);
        updateTitle(theme);
      });
    }
    (function initThemeDropdown() {
      var themeBtn = document.getElementById('themeCharmBtn');
      var dropdown = document.getElementById('themeDropdown');
      if (!themeBtn || !dropdown) return;
      themeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('open');
      });
      dropdown.querySelectorAll('.theme-dropdown-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
          var theme = this.getAttribute('data-theme');
          if (themeSelect) {
            themeSelect.value = theme;
            themeSelect.dispatchEvent(new Event('change'));
          }
          dropdown.classList.remove('open');
        });
      });
      document.addEventListener('click', function() { dropdown.classList.remove('open'); });
    })();
    const clockEl = document.getElementById('clock');
    let data = <?= json_encode($initialData) ?>;
    let sortables = [];

    function updateClock() {
      const now = new Date();
      const timeStr = now.toTimeString().slice(0, 5);
      clockEl.textContent = timeStr;
      if (window._screensaverActive && window._screensaverClockEl) {
        window._screensaverClockEl.textContent = timeStr;
      }
    }
    const DEFAULT_TIME_BLOCKS = [
      { label: 'Work Day', time: 0 },
      { label: 'Tea Time', time: 9 },
      { label: 'Lunch', time: 11 },
      { label: 'Tea Time', time: 12 },
      { label: 'Dog walk', time: 14 },
      { label: 'Dinner', time: 17 },
      { label: 'Bed time', time: 18.5 },
      { label: 'Complete', time: 22.75 }
    ];
    function getTimeBlocks() {
      let blocks = (data && data.events && data.events.length) ? data.events : DEFAULT_TIME_BLOCKS;
      blocks = blocks.map(b => {
        if ('start' in b && !('time' in b)) return { ...b, time: b.start };
        return b;
      });
      return [...blocks].sort((a, b) => ((a.time ?? a.start ?? 0) - (b.time ?? b.start ?? 0)) || ((a.order ?? 0) - (b.order ?? 0)));
    }
    function minsSinceMidnight(h, m) { return h * 60 + m; }
    function decimalToTimeStr(d) {
      if (d == null || isNaN(d)) return '00:00';
      if (d >= 24) return '24:00';
      const h = Math.floor(d);
      const m = Math.round((d % 1) * 60);
      return String(h).padStart(2, '0') + ':' + String(m % 60).padStart(2, '0');
    }
    function timeStrToDecimal(str) {
      if (!str || typeof str !== 'string') return NaN;
      const parts = str.trim().split(/[:\s]+/);
      const h = parseInt(parts[0], 10);
      const m = parseInt(parts[1], 10) || 0;
      if (isNaN(h)) return NaN;
      return h + m / 60;
    }
    function getDayBarHtml(includeEditBtn) {
      const blocks = getTimeBlocks();
      if (blocks.length === 0) {
        const emptyHtml = '<div class="day-bar-label">No events</div><div class="day-bar-track"></div>';
        const core = emptyHtml;
        if (includeEditBtn) return `<div class="day-bar-wrap"><button class="edit-blocks-btn" type="button" id="editBlocksBtn" title="Edit daily events">Edit events</button><div class="day-bar">${core}</div></div>`;
        return `<div class="day-bar">${core}</div>`;
      }
      const now = new Date();
      const mins = minsSinceMidnight(now.getHours(), now.getMinutes());
      const timesM = blocks.map(b => (b.time ?? b.start ?? 0) * 60);
      const currentIdx = blocks.findIndex((b, i) => {
        const t = (b.time ?? b.start ?? 0) * 60;
        return mins >= t && (i === blocks.length - 1 || mins < timesM[i + 1]);
      });
      const current = currentIdx >= 0 ? blocks[currentIdx] : blocks[blocks.length - 1];
      const nextIdx = blocks.findIndex(b => (b.time ?? b.start ?? 0) * 60 > mins);
      const next = nextIdx >= 0 ? blocks[nextIdx] : null;
      let label, startM, endM, pct;
      if (!next) {
        startM = timesM[timesM.length - 1] ?? 0;
        endM = 24 * 60;
        pct = mins >= startM ? 100 : 0;
        label = 'Loading complete ' + Math.round(pct) + '%';
      } else {
        const prevTime = nextIdx > 0 ? timesM[nextIdx - 1] : 0;
        startM = prevTime;
        endM = timesM[nextIdx];
        const totalM = endM - startM;
        pct = mins <= startM ? 0 : mins >= endM ? 100 : Math.min(100, ((mins - startM) / totalM) * 100);
        label = 'Loading ' + escapeHtml(toTitleCase(next.label || next.name || next.title || '')) + ' ' + Math.round(pct) + '%';
      }
      const segments = 20;
      const filled = Math.round((pct / 100) * segments);
      const segmentsHtml = Array.from({length: segments}, (_, i) => {
        const isFilled = i < filled;
        return `<div class="day-bar-segment${isFilled ? ' filled' : ''}"></div>`;
      }).join('');
      const coreHtml = `<div class="day-bar-label">${label}</div><div class="day-bar-track">${segmentsHtml}</div>`;
      if (includeEditBtn) {
        return `<div class="day-bar-wrap"><button class="edit-blocks-btn" type="button" id="editBlocksBtn" title="Edit time blocks">Edit blocks</button><div class="day-bar">${coreHtml}</div></div>`;
      }
      return `<div class="day-bar">${coreHtml}</div>`;
    }
    function updateDayBars() {
      const dayBarsEl = document.getElementById('dayBars');
      dayBarsEl.innerHTML = getDayBarHtml(true);
      const editBtn = document.getElementById('editBlocksBtn');
      if (editBtn) editBtn.addEventListener('click', openTimeBlocksModal);
      if (window._screensaverActive && window._screensaverDayBarsEl) {
        window._screensaverDayBarsEl.innerHTML = getDayBarHtml(false);
      }
    }
    updateClock();
    updateDayBars();
    setInterval(updateClock, 1000);
    setInterval(updateDayBars, 60000);

    (function initScreensaver() {
      const IDLE_MS = 60000;
      const overlay = document.getElementById('screensaverOverlay');
      const mystifyCanvas = document.getElementById('screensaverMystify');
      const screensaverClock = document.getElementById('screensaverClock');
      const screensaverDayBars = document.getElementById('screensaverDayBars');
      let idleTimer = null;
      let mystifyRAF = null;
      let mystifyLastDraw = 0;
      let mystifyPoints = [];
      let mystifyHistory = [];
      let manualActivationGraceUntil = 0;
      let modalsOpenBeforeScreensaver = [];

      const MYSTIFY_THEME = {
        ps5: { fps: 60, scale: 1 },
        tron: { fps: 60, scale: 1 },
        'tron-ares': { fps: 60, scale: 1 },
        megadrive: { fps: 15, scale: 0.75 },
        sms: { fps: 15, scale: 0.75 },
        gb: { fps: 10, scale: 0.5 },
        matrix: { fps: 10, scale: 0.5 },
        macintosh: { fps: 15, scale: 0.66 },
        msdos: { fps: 15, scale: 0.66 }
      };

      function getMystifyThemeConfig() {
        const t = document.documentElement.getAttribute('data-theme') || '';
        return MYSTIFY_THEME[t] || { fps: 30, scale: 1 };
      }

      function resetIdleTimer() {
        if (idleTimer) clearTimeout(idleTimer);
        idleTimer = setTimeout(enterScreensaver, IDLE_MS);
      }

      function getMystifyColor() {
        return getComputedStyle(document.documentElement).getPropertyValue('--content').trim() || '#e0e0ff';
      }

      function drawMystify(now) {
        if (!mystifyCanvas || !overlay.classList.contains('active')) return;
        now = now || performance.now();
        const cfg = getMystifyThemeConfig();
        const frameInterval = 1000 / cfg.fps;
        if (now - mystifyLastDraw < frameInterval) {
          mystifyRAF = requestAnimationFrame(drawMystify);
          return;
        }
        mystifyLastDraw = now;
        const ctx = mystifyCanvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const scale = cfg.scale;
        const w = mystifyCanvas.width / (dpr * scale);
        const h = mystifyCanvas.height / (dpr * scale);
        const bgColor = getComputedStyle(document.documentElement).getPropertyValue('--bg').trim() || '#1a1630';
        const bgRgb = bgColor.startsWith('#') ? hexToRgb(bgColor) : parseRgb(bgColor);
        ctx.fillStyle = bgRgb ? 'rgb(' + bgRgb.r + ',' + bgRgb.g + ',' + bgRgb.b + ')' : '#1a1630';
        ctx.fillRect(0, 0, w, h);
        const color = getMystifyColor();
        const rgb = color.startsWith('#') ? hexToRgb(color) : parseRgb(color);
        const baseRgb = rgb ? (rgb.r + ',' + rgb.g + ',' + rgb.b) : '224,224,255';
        ctx.lineWidth = scale < 1 ? Math.max(1, 2 * scale) : 2;
        function drawPoly(points, alpha) {
          if (!points || points.length < 2) return;
          ctx.strokeStyle = 'rgba(' + baseRgb + ',' + alpha + ')';
          ctx.beginPath();
          ctx.moveTo(points[0].x, points[0].y);
          for (let i = 1; i < points.length; i++) ctx.lineTo(points[i].x, points[i].y);
          ctx.closePath();
          ctx.stroke();
        }
        if (mystifyHistory.length >= 2) drawPoly(mystifyHistory[0], 0.12);
        if (mystifyHistory.length >= 1) drawPoly(mystifyHistory[mystifyHistory.length - 1], 0.25);
        drawPoly(mystifyPoints, 0.4);
        const snapshot = mystifyPoints.map(function(p) { return { x: p.x, y: p.y }; });
        mystifyHistory.push(snapshot);
        if (mystifyHistory.length > 2) mystifyHistory.shift();
        const speedMul = 60 / cfg.fps;
        for (let i = 0; i < mystifyPoints.length; i++) {
          const p = mystifyPoints[i];
          p.x += p.dx * speedMul;
          p.y += p.dy * speedMul;
          if (p.x <= 0 || p.x >= w) p.dx = -p.dx;
          if (p.y <= 0 || p.y >= h) p.dy = -p.dy;
        }
        mystifyRAF = requestAnimationFrame(drawMystify);
      }
      function hexToRgb(hex) {
        const m = hex.slice(1).match(/.{2}/g);
        return m ? { r: parseInt(m[0], 16), g: parseInt(m[1], 16), b: parseInt(m[2], 16) } : null;
      }
      function parseRgb(s) {
        const m = s.match(/\d+/g);
        return m && m.length >= 3 ? { r: +m[0], g: +m[1], b: +m[2] } : null;
      }

      function resizeMystify() {
        if (!mystifyCanvas || !overlay) return;
        const dpr = window.devicePixelRatio || 1;
        const cfg = getMystifyThemeConfig();
        const scale = cfg.scale;
        const w = window.innerWidth;
        const h = window.innerHeight;
        mystifyCanvas.width = w * dpr * scale;
        mystifyCanvas.height = h * dpr * scale;
        mystifyCanvas.style.width = w + 'px';
        mystifyCanvas.style.height = h + 'px';
        if (scale < 1) mystifyCanvas.setAttribute('data-retro', '');
        else mystifyCanvas.removeAttribute('data-retro');
        const ctx = mystifyCanvas.getContext('2d');
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr * scale, dpr * scale);
        if (mystifyPoints.length === 0) {
          const n = 8;
          for (let i = 0; i < n; i++) {
            mystifyPoints.push({
              x: Math.random() * w,
              y: Math.random() * h,
              dx: (Math.random() - 0.5) * 4,
              dy: (Math.random() - 0.5) * 4
            });
          }
        } else {
          for (const p of mystifyPoints) {
            p.x = Math.min(Math.max(p.x, 0), w);
            p.y = Math.min(Math.max(p.y, 0), h);
          }
        }
        mystifyHistory = [];
      }

      function enterScreensaver(manualActivation) {
        if (window._screensaverActive) return;
        window._screensaverActive = true;
        manualActivationGraceUntil = manualActivation ? Date.now() + 2000 : 0;
        window._screensaverClockEl = screensaverClock;
        window._screensaverDayBarsEl = screensaverDayBars;
        modalsOpenBeforeScreensaver = [];
        document.querySelectorAll('.modal-overlay.open').forEach(function(m) {
          modalsOpenBeforeScreensaver.push(m.id || m);
          m.classList.remove('open');
        });
        document.body.classList.add('screensaver-active');
        overlay.classList.add('active');
        overlay.setAttribute('aria-hidden', 'false');
        mystifyHistory = [];
        mystifyLastDraw = 0;
        resizeMystify();
        updateClock();
        screensaverDayBars.innerHTML = getDayBarHtml(false);
        if (window._midiPlayerUpdateScreensaverTrack) window._midiPlayerUpdateScreensaverTrack();
        drawMystify();
      }

      function exitScreensaver() {
        if (!window._screensaverActive) return;
        window._screensaverActive = false;
        window._screensaverClockEl = null;
        window._screensaverDayBarsEl = null;
        document.body.classList.remove('screensaver-active');
        overlay.classList.remove('active');
        overlay.setAttribute('aria-hidden', 'true');
        modalsOpenBeforeScreensaver.forEach(function(id) {
          var el = typeof id === 'string' ? document.getElementById(id) : id;
          if (el) el.classList.add('open');
        });
        modalsOpenBeforeScreensaver = [];
        if (mystifyRAF) {
          cancelAnimationFrame(mystifyRAF);
          mystifyRAF = null;
        }
      }

      const screensaverBtn = document.getElementById('screensaverBtn');
      if (screensaverBtn) {
        screensaverBtn.addEventListener('click', function() {
          enterScreensaver(true);
        });
      }
      resizeMystify();
      window.addEventListener('resize', resizeMystify);
      (function observeTheme() {
        var mo = new MutationObserver(function() {
          if (overlay && overlay.classList.contains('active')) resizeMystify();
        });
        mo.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
      })();
      resetIdleTimer();
      document.addEventListener('mousemove', function() {
        if (window._screensaverActive) {
          if (manualActivationGraceUntil > 0 && Date.now() < manualActivationGraceUntil) return;
          exitScreensaver();
        }
        resetIdleTimer();
      });
      ['mousedown', 'keydown', 'touchstart', 'scroll'].forEach(function(ev) {
        document.addEventListener(ev, function() {
          if (window._screensaverActive) exitScreensaver();
          resetIdleTimer();
        });
      });
    })();

    const editModeBtn = document.getElementById('editModeBtn');
    const categoriesContainer = document.getElementById('categoriesContainer');
    const itemModal = document.getElementById('itemModal');
    const modalTitleEl = document.getElementById('modalTitle');
    const modalItemId = document.getElementById('modalItemId');
    const modalCategoryId = document.getElementById('modalCategoryId');
    const modalItemTitle = document.getElementById('modalItemTitle');
    const modalItemSubtitle = document.getElementById('modalItemSubtitle');
    const modalItemUrl = document.getElementById('modalItemUrl');
    const modalItemColor = document.getElementById('modalItemColor');
    const modalCancelBtn = document.getElementById('modalCancelBtn');
    const modalSaveBtn = document.getElementById('modalSaveBtn');

    function api(action, body) {
      const opts = { method: body ? 'POST' : 'GET' };
      let url = 'api.php?action=' + action;
      if (body) {
        opts.headers = { 'Content-Type': 'application/json' };
        opts.body = JSON.stringify(body);
      }
      return fetch(url, opts).then(function(r) {
        return r.text().then(function(text) {
          var json = {};
          try {
            json = text ? JSON.parse(text) : {};
          } catch (e) {}
          if (!r.ok) throw new Error(json.error || 'Request failed (' + r.status + ')');
          return json;
        });
      });
    }

    function renderCard(item, categoryId) {
      const colorClass = item.color ? ' link-card--' + item.color : '';
      return `
        <div class="link-card${colorClass}" data-id="${item.id}" data-category-id="${categoryId}" data-href="${item.url}">
          <div class="link-card-content">
            <span class="link-title">${escapeHtml(item.title)}</span>
            <span class="link-subtitle">${escapeHtml(item.subtitle || '')}</span>
          </div>
          <div class="link-actions">
            <button class="edit-item-btn" type="button" title="Edit">✎</button>
            <button class="delete-item-btn" type="button" title="Delete">✕</button>
            <a class="link-icon" href="${escapeHtml(item.url)}" target="_blank" rel="noopener" title="Visit">Visit</a>
          </div>
        </div>
      `;
    }

    function render() {
      categoriesContainer.innerHTML = '';
      sortables = [];

      const hasCategories = (data.categories || []).length > 0;
      app.classList.toggle('empty-categories', !hasCategories);

      const addCatRow = document.createElement('div');
      addCatRow.className = 'add-category-row';
      addCatRow.innerHTML = (hasCategories ? '' : '<p class="empty-state-msg">No categories yet. Add a category to get started.</p>') +
        '<button class="add-category-btn" type="button" id="addCategoryBtn">+ Add category</button>';
      categoriesContainer.appendChild(addCatRow);
      document.getElementById('addCategoryBtn').addEventListener('click', openAddCategoryModal);

      (data.categories || []).sort((a, b) => (a.order ?? 0) - (b.order ?? 0)).forEach(cat => {
        const items = (cat.items || []).sort((a, b) => (a.order ?? 0) - (b.order ?? 0));
        const section = document.createElement('section');
        section.dataset.categoryId = cat.id;
        section.innerHTML = `
          <div class="section-header">
            <div class="section-title">${escapeHtml(cat.title)}</div>
            <button class="add-item-btn" type="button" data-category-id="${cat.id}">+ Add</button>
          </div>
          <div class="links">${items.map(i => renderCard(i, cat.id)).join('')}</div>
        `;
        categoriesContainer.appendChild(section);

        const linksEl = section.querySelector('.links');
        section.querySelector('.add-item-btn').addEventListener('click', () => openAddModal(cat.id));
        linksEl.querySelectorAll('.edit-item-btn').forEach(btn => {
          btn.addEventListener('click', e => {
            e.stopPropagation();
            const card = btn.closest('.link-card');
            openEditModal(card.dataset.id, card.dataset.categoryId);
          });
        });
        linksEl.querySelectorAll('.delete-item-btn').forEach(btn => {
          btn.addEventListener('click', e => {
            e.stopPropagation();
            if (confirm('Delete this item?')) deleteItem(btn.closest('.link-card').dataset.id);
          });
        });
        linksEl.querySelectorAll('.link-icon').forEach(a => {
          a.addEventListener('click', function(e) {
            if (app.classList.contains('edit-mode')) return;
            e.preventDefault();
            const href = this.getAttribute('href');
            if (!href) return;
            const btn = this;
            const rect = btn.getBoundingClientRect();
            const overlay = document.createElement('div');
            overlay.className = 'visit-zoom-overlay';
            const box = document.createElement('div');
            box.className = 'visit-zoom-box';
            const w = window.innerWidth;
            const h = window.innerHeight;
            const duration = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--visit-zoom-duration')) * 1000 || 350;
            const easing = getComputedStyle(document.documentElement).getPropertyValue('--visit-zoom-easing').trim() || 'ease-in-out';
            box.style.left = rect.left + 'px';
            box.style.top = rect.top + 'px';
            box.style.width = rect.width + 'px';
            box.style.height = rect.height + 'px';
            box.style.transition = 'left ' + (duration / 1000) + 's ' + easing + ', top ' + (duration / 1000) + 's ' + easing + ', width ' + (duration / 1000) + 's ' + easing + ', height ' + (duration / 1000) + 's ' + easing;
            overlay.appendChild(box);
            document.body.appendChild(overlay);
            requestAnimationFrame(() => {
              requestAnimationFrame(() => {
                box.style.left = '0';
                box.style.top = '0';
                box.style.width = w + 'px';
                box.style.height = h + 'px';
              });
            });
            setTimeout(() => {
              overlay.classList.add('zoom-done');
              window.open(href, '_blank', 'noopener');
              setTimeout(() => overlay.remove(), 50);
            }, duration);
          });
        });
        sortables.push(new Sortable(linksEl, {
          animation: 150,
          ghostClass: 'sortable-ghost',
          onEnd: () => saveOrder(cat.id, linksEl)
        }));
      });
    }

    function saveOrder(categoryId, linksEl) {
      const itemIds = [...linksEl.querySelectorAll('.link-card')].map(c => c.dataset.id);
      api('reorder', { categoryId, itemIds }).then(() => load());
    }

    const categoryModal = document.getElementById('categoryModal');
    const categoryModalTitleInput = document.getElementById('categoryModalTitleInput');

    function openAddCategoryModal() {
      document.getElementById('categoryModalTitle').textContent = 'Add Category';
      categoryModalTitleInput.value = '';
      categoryModal.classList.add('open');
    }

    function closeCategoryModal() {
      categoryModal.classList.remove('open');
    }

    function saveCategory() {
      const title = categoryModalTitleInput.value.trim();
      if (!title) {
        alert('Title is required');
        return;
      }
      api('addCategory', { title })
        .then((res) => {
          if (res && res.success && res.category) {
            data.categories = data.categories || [];
            data.categories.push(res.category);
            closeCategoryModal();
            render();
          } else {
            alert(res && res.error ? res.error : 'Save failed.');
          }
        })
        .catch((e) => alert('Save failed: ' + (e.message || 'Please try again.')));
    }

    function openAddModal(categoryId) {
      modalTitleEl.textContent = 'Add Item';
      modalItemId.value = '';
      modalCategoryId.value = categoryId;
      modalItemTitle.value = '';
      modalItemSubtitle.value = '';
      modalItemUrl.value = '';
      modalItemColor.value = '';
      itemModal.classList.add('open');
    }

    function openEditModal(itemId, categoryId) {
      const item = data.categories.flatMap(c => c.items || []).find(i => i.id === itemId);
      if (!item) return;
      modalTitleEl.textContent = 'Edit Item';
      modalItemId.value = itemId;
      modalCategoryId.value = categoryId;
      modalItemTitle.value = item.title;
      modalItemSubtitle.value = item.subtitle || '';
      modalItemUrl.value = item.url;
      modalItemColor.value = item.color || '';
      itemModal.classList.add('open');
    }

    function closeModal() {
      itemModal.classList.remove('open');
    }

    function saveItem() {
      const id = modalItemId.value;
      const title = modalItemTitle.value.trim();
      const subtitle = modalItemSubtitle.value.trim();
      const url = modalItemUrl.value.trim();
      const color = modalItemColor.value;
      const categoryId = modalCategoryId.value;

      if (!title || !url) {
        alert('Title and URL are required');
        return;
      }

      function updateLocalEdit() {
        for (const cat of data.categories) {
          const item = (cat.items || []).find(i => i.id === id);
          if (item) {
            item.title = title;
            item.subtitle = subtitle;
            item.url = url;
            item.color = color;
            return;
          }
        }
      }

      function updateLocalAdd(newItem) {
        const cat = data.categories.find(c => c.id === categoryId);
        if (cat) {
          cat.items = cat.items || [];
          cat.items.push(newItem);
        }
      }

      if (id) {
        api('edit', { id, title, subtitle, url, color })
          .then((res) => {
            if (res && res.success !== false) {
              updateLocalEdit();
              closeModal();
              render();
            } else {
              alert('Save failed. Please try again.');
            }
          })
          .catch(() => {
            alert('Save failed. Check if the server is responding.');
          });
      } else {
        api('add', { categoryId, title, subtitle, url, color })
          .then((res) => {
            if (res && res.success && res.item) {
              updateLocalAdd(res.item);
              closeModal();
              render();
            } else {
              alert('Save failed. Please try again.');
            }
          })
          .catch(() => {
            alert('Save failed. Check if the server is responding.');
          });
      }
    }

    function deleteItem(id) {
      api('delete', { id }).then(() => load());
    }

    function load() {
      api('get').then(d => {
        data = d;
        render();
        updateDayBars();
        if (window._midiPlayerRefresh) window._midiPlayerRefresh();
        if (window._midiPlayerTryRestore) window._midiPlayerTryRestore();
      }).catch(() => {
        render();
        if (window._midiPlayerTryRestore) window._midiPlayerTryRestore();
      });
    }

    const timeBlocksModal = document.getElementById('timeBlocksModal');
    const timeBlockFormModal = document.getElementById('timeBlockFormModal');
    const timeBlocksList = document.getElementById('timeBlocksList');

    function openTimeBlocksModal() {
      const blocks = getTimeBlocks();
      const hasCustom = !!(data && data.events && data.events.length);
      timeBlocksList.innerHTML = (hasCustom ? '' : '<div class="time-block-row" style="color:var(--content-muted);margin-bottom:0.5rem">Using defaults. Add events to customize.</div>') + blocks.map(b => {
        const isCustom = !!b.id;
        const t = b.time ?? b.start ?? 0;
        return `
        <div class="time-block-row" data-id="${escapeHtml(b.id || '')}">
          <span>${escapeHtml(b.label)} (${decimalToTimeStr(t)})</span>
          ${isCustom ? '<button class="tb-edit" type="button" title="Edit">Edit</button><button class="tb-delete" type="button" title="Delete">Delete</button>' : ''}
        </div>`;
      }).join('');
      timeBlocksList.querySelectorAll('.tb-edit').forEach(btn => {
        btn.addEventListener('click', () => openTimeBlockFormEdit(btn.closest('.time-block-row').dataset.id));
      });
      timeBlocksList.querySelectorAll('.tb-delete').forEach(btn => {
        btn.addEventListener('click', () => {
          if (confirm('Delete this event?')) deleteTimeBlock(btn.closest('.time-block-row').dataset.id);
        });
      });
      timeBlocksModal.classList.add('open');
    }

    function closeTimeBlocksModal() {
      timeBlocksModal.classList.remove('open');
    }

    function openTimeBlockForm(editId) {
      document.getElementById('timeBlockFormTitle').textContent = editId ? 'Edit Event' : 'Add Event';
      document.getElementById('tbFormId').value = editId || '';
      const block = editId ? getTimeBlocks().find(b => b.id === editId) : null;
      document.getElementById('tbFormLabel').value = block ? block.label : '';
      document.getElementById('tbFormTime').value = block ? decimalToTimeStr(block.time ?? block.start ?? 0) : '';
      timeBlockFormModal.classList.add('open');
    }

    function openTimeBlockFormEdit(id) {
      closeTimeBlocksModal();
      openTimeBlockForm(id);
    }

    function closeTimeBlockFormModal() {
      timeBlockFormModal.classList.remove('open');
    }

    function saveTimeBlock() {
      const id = document.getElementById('tbFormId').value;
      const label = document.getElementById('tbFormLabel').value.trim();
      const time = timeStrToDecimal(document.getElementById('tbFormTime').value);
      if (!label) {
        alert('Label is required');
        return;
      }
      if (isNaN(time) || time < 0 || time > 24) {
        alert('Time must be in HH:MM format, between 00:00 and 24:00');
        return;
      }
      if (id) {
        api('editTimeBlock', { id, label, time })
          .then(() => {
            for (const b of (data.events || [])) {
              if (b.id === id) {
                b.label = label;
                b.time = time;
                delete b.start;
                delete b.end;
                delete b.color;
                break;
              }
            }
            closeTimeBlockFormModal();
            updateDayBars();
            openTimeBlocksModal();
          })
          .catch(e => alert('Save failed: ' + (e.message || 'Please try again')));
      } else {
        api('addTimeBlock', { label, time })
          .then(res => {
            if (res && res.success && res.block) {
              data.events = data.events || [];
              data.events.push(res.block);
              closeTimeBlockFormModal();
              updateDayBars();
              openTimeBlocksModal();
            }
          })
          .catch(e => alert('Save failed: ' + (e.message || 'Please try again')));
      }
    }

    function deleteTimeBlock(id) {
      api('deleteTimeBlock', { id })
        .then(() => {
          data.events = (data.events || []).filter(b => b.id !== id);
          updateDayBars();
          openTimeBlocksModal();
        })
        .catch(e => alert('Delete failed: ' + (e.message || 'Please try again')));
    }

    document.getElementById('addTimeBlockBtn').addEventListener('click', () => {
      closeTimeBlocksModal();
      openTimeBlockForm();
    });
    document.getElementById('closeTimeBlocksBtn').addEventListener('click', closeTimeBlocksModal);
    document.getElementById('tbFormCancelBtn').addEventListener('click', closeTimeBlockFormModal);
    document.getElementById('timeBlockForm').addEventListener('submit', function(e) {
      e.preventDefault();
      saveTimeBlock();
    });
    timeBlocksModal.addEventListener('click', e => { if (e.target === timeBlocksModal) closeTimeBlocksModal(); });
    timeBlockFormModal.addEventListener('click', e => { if (e.target === timeBlockFormModal) closeTimeBlockFormModal(); });

    editModeBtn.addEventListener('click', () => {
      app.classList.toggle('edit-mode');
      editModeBtn.classList.toggle('active', app.classList.contains('edit-mode'));
      editModeBtn.title = app.classList.contains('edit-mode') ? 'Done' : 'Edit';
    });

    (function initScratchPad() {
      const el = document.getElementById('scratchPadText');
      const textTab = document.getElementById('scratchPadTextTab');
      const basicTab = document.getElementById('scratchPadBasicTab');
      const jsTab = document.getElementById('scratchPadJsTab');
      const stopBtn = document.getElementById('scratchPadStopBtn');
      const runJsBtn = document.getElementById('scratchPadRunJsBtn');
      let activeTab = 'text';
      let textContent = '';
      let basicContent = '';
      let jsContent = '';
      let isStreaming = false;
      let streamTimeoutId = null;
      let stateBeforeRun = '';
      let stateBeforeOutput = '';
      let hasOutputFromRun = false;

      try {
        const legacy = localStorage.getItem('devStartPageScratch') || '';
        textContent = localStorage.getItem('devStartPageScratchText') || '';
        basicContent = localStorage.getItem('devStartPageScratchBasic') || '';
        jsContent = localStorage.getItem('devStartPageScratchJs') || '';
        activeTab = localStorage.getItem('devStartPageScratchTab') || 'text';
        if (legacy && !textContent && !basicContent && !jsContent) {
          textContent = legacy;
          basicContent = legacy;
          jsContent = legacy;
        }
      } catch (e) {}
      function saveContent() {
        if (activeTab === 'text') textContent = el.value;
        else if (activeTab === 'basic') basicContent = el.value;
        else if (activeTab === 'javascript') jsContent = el.value;
        try {
          localStorage.setItem('devStartPageScratchText', textContent);
          localStorage.setItem('devStartPageScratchBasic', basicContent);
          localStorage.setItem('devStartPageScratchJs', jsContent);
        } catch (e) {}
      }
      let initialLoad = true;
      function switchTab(tab) {
        if (!initialLoad) saveContent();
        initialLoad = false;
        activeTab = tab;
        try { localStorage.setItem('devStartPageScratchTab', activeTab); } catch (e) {}
        if (tab === 'text') el.value = textContent;
        else if (tab === 'basic') el.value = basicContent;
        else el.value = jsContent;
        el.placeholder = tab === 'text' ? 'Notes, reminders, quick thoughts...' : tab === 'basic' ? '10 PRINT "Hello"\n20 GOTO 10\nRUN' : 'console.log("Hello");\n\n// Click RUN or Ctrl+Enter to execute';
        textTab.classList.toggle('active', tab === 'text');
        basicTab.classList.toggle('active', tab === 'basic');
        jsTab.classList.toggle('active', tab === 'javascript');
        updateActionButtons();
      }
      function updateActionButtons() {
        const inBasic = activeTab === 'basic';
        const inJs = activeTab === 'javascript';
        const showStopBtn = inBasic && (isStreaming || hasOutputFromRun);
        stopBtn.style.display = showStopBtn ? '' : 'none';
        stopBtn.textContent = isStreaming ? 'STOP' : 'RESET';
        stopBtn.title = isStreaming ? 'Stop execution' : 'Reset to before RUN';
        runJsBtn.style.display = inJs ? '' : 'none';
      }
      el.addEventListener('input', saveContent);
      if (textTab) textTab.addEventListener('click', () => switchTab('text'));
      if (basicTab) basicTab.addEventListener('click', () => switchTab('basic'));
      if (jsTab) jsTab.addEventListener('click', () => switchTab('javascript'));
      switchTab(activeTab);

      function runJavaScript(source) {
        const outBuf = [];
        const origLog = console.log;
        const origWarn = console.warn;
        const origError = console.error;
        console.log = function() { outBuf.push(Array.from(arguments).map(String).join(' ')); };
        console.warn = function() { outBuf.push(Array.from(arguments).map(String).join(' ')); };
        console.error = function() { outBuf.push(Array.from(arguments).map(String).join(' ')); };
        try {
          const fn = new Function(source);
          const result = fn();
          if (result !== undefined) outBuf.push(String(result));
        } catch (e) {
          outBuf.push('Error: ' + (e.message || e));
        } finally {
          console.log = origLog;
          console.warn = origWarn;
          console.error = origError;
        }
        return outBuf.join('\n') + (outBuf.length ? '\n' : '');
      }

      function runBasic(source) {
        const lines = [];
        const vars = {};
        const MAX_ITER = 10000;
        const MAX_OUTPUT = 50000;
        let iter = 0;
        let outputLen = 0;
        const outBuf = [];

        function out(s) {
          const t = String(s);
          outputLen += t.length;
          if (outputLen <= MAX_OUTPUT) outBuf.push(t);
        }

        (source || '').split(/\r?\n/).forEach(function(line) {
          line = line.trim();
          if (!line) return;
          const m = line.match(/^(\d+)\s+(.*)$/);
          if (m) {
            lines.push({ num: parseInt(m[1], 10), rest: m[2].trim() });
          }
        });
        lines.sort(function(a, b) { return a.num - b.num; });
        if (lines.length === 0) {
          return '\n?NO PROGRAM\n';
        }

        function evalExpr(s) {
          s = (s || '').trim();
          if (!s) return 0;
          if (/^\d+(\.\d*)?$/.test(s)) return parseFloat(s);
          if (/^"[^"]*"$/.test(s)) return s.slice(1, -1);
          if (/^[A-Za-z_][A-Za-z0-9_]*$/.test(s)) return vars[s] != null ? vars[s] : 0;
          const m = s.match(/^([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.+)$/);
          if (m) {
            vars[m[1]] = evalExpr(m[2]);
            return vars[m[1]];
          }
          const parts = s.split(/\s*([+\-*\/]|\*\*)\s*/).filter(Boolean);
          if (parts.length >= 3) {
            let acc = evalExpr(parts[0]);
            for (let i = 1; i < parts.length; i += 2) {
              const o = parts[i];
              const r = evalExpr(parts[i + 1]);
              if (o === '+') acc += r;
              else if (o === '-') acc -= r;
              else if (o === '*') acc *= r;
              else if (o === '/') acc /= r;
              else if (o === '**') acc = Math.pow(acc, r);
            }
            return acc;
          }
          return 0;
        }

        function findLine(num) {
          for (let i = 0; i < lines.length; i++) {
            if (lines[i].num >= num) return i;
          }
          return -1;
        }

        let pc = 0;
        while (pc >= 0 && pc < lines.length && iter < MAX_ITER) {
          iter++;
          const ln = lines[pc];
          let rest = ln.rest;
          const restUpper = rest.toUpperCase();
          let match;

          if (restUpper === 'END' || rest === '') {
            break;
          }
          if ((match = rest.match(/^PRINT\s+(.*)$/i))) {
            let arg = match[1].trim();
            if (arg.startsWith('"') && arg.indexOf('"', 1) >= 0) {
              const end = arg.indexOf('"', 1);
              out(arg.slice(1, end) + '\n');
            } else {
              out(String(evalExpr(arg)) + '\n');
            }
          } else if ((match = rest.match(/^GO\s+TO\s+(\d+)$/i)) || (match = rest.match(/^GOTO\s+(\d+)$/i))) {
            const idx = findLine(parseInt(match[1], 10));
            if (idx >= 0) { pc = idx; continue; }
          } else if ((match = rest.match(/^LET\s+(.+)$/i))) {
            evalExpr(match[1].trim());
          } else if ((match = rest.match(/^([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.+)$/))) {
            vars[match[1]] = evalExpr(match[2].trim());
          } else {
            out('?SYNTAX ERROR\n');
          }
          pc++;
        }
        if (iter >= MAX_ITER) out('\n*** STOPPED AFTER ' + MAX_ITER + ' STEPS ***\n');
        if (outputLen >= MAX_OUTPUT) out('\n*** OUTPUT TRUNCATED ***\n');
        return outBuf.join('');
      }

      el.addEventListener('keydown', function(e) {
        if (activeTab === 'javascript' && (e.ctrlKey || e.metaKey) && e.key === 'Enter') {
          e.preventDefault();
          runJsBtn && runJsBtn.click();
          return;
        }
        if (e.key !== 'Enter' || activeTab !== 'basic' || isStreaming) return;
        const text = el.value;
        const pos = el.selectionStart;
        const lineStart = text.lastIndexOf('\n', pos - 1) + 1;
        const currentLine = text.slice(lineStart, pos).trim();
        if (currentLine.toUpperCase() !== 'RUN') return;
        e.preventDefault();
        const before = text.slice(0, pos);
        const after = text.slice(pos);
        stateBeforeRun = text.slice(0, lineStart).replace(/\n+$/, '');
        stateBeforeOutput = before + '\n';
        hasOutputFromRun = false;
        const output = runBasic(text);
        const lines = output.split('\n');
        const linesPerSec = 10;
        const intervalMs = 1000 / linesPerSec;
        el.value = stateBeforeOutput;
        el.readOnly = true;
        isStreaming = true;
        updateActionButtons();
        let lineIdx = 0;
        function tick() {
          if (!isStreaming) return;
          if (lineIdx < lines.length) {
            const line = lines[lineIdx];
            const suffix = (lineIdx < lines.length - 1 || !output.endsWith('\n')) ? '\n' : '';
            el.value += line + suffix;
            el.scrollTop = el.scrollHeight;
            lineIdx++;
          }
          if (lineIdx >= lines.length) {
            el.value += after;
            el.readOnly = false;
            basicContent = el.value;
            saveContent();
            isStreaming = false;
            hasOutputFromRun = true;
            updateActionButtons();
            el.selectionStart = el.selectionEnd = el.value.length;
            return;
          }
          streamTimeoutId = setTimeout(tick, intervalMs);
        }
        streamTimeoutId = setTimeout(tick, intervalMs);
      });
      if (stopBtn) {
        stopBtn.addEventListener('click', function() {
          if (isStreaming) {
            if (streamTimeoutId) clearTimeout(streamTimeoutId);
            streamTimeoutId = null;
            isStreaming = false;
            el.readOnly = false;
            hasOutputFromRun = true;
            basicContent = el.value;
            saveContent();
          } else if (hasOutputFromRun) {
            el.value = stateBeforeOutput;
            el.selectionStart = el.selectionEnd = stateBeforeOutput.length;
            basicContent = el.value;
            hasOutputFromRun = false;
            saveContent();
          }
          updateActionButtons();
        });
      }
      if (runJsBtn) {
        runJsBtn.addEventListener('click', function() {
          if (activeTab !== 'javascript') return;
          const raw = el.value;
          const code = raw.includes('// --- output ---') ? raw.split('// --- output ---')[0].trimEnd() : raw;
          jsContent = code;
          saveContent();
          const output = runJavaScript(code);
          el.value = code + (output ? '\n\n// --- output ---\n' + output : '');
          el.scrollTop = el.scrollHeight;
        });
      }

      const maxBtn = document.getElementById('scratchPadMaximizeBtn');
      if (maxBtn) {
        maxBtn.addEventListener('click', function() {
          const isMax = document.body.classList.toggle('scratch-pad-maximized');
          maxBtn.textContent = isMax ? '\u2921' : '\u26B6';
          maxBtn.title = isMax ? 'Restore' : 'Full screen';
        });
      }
    })();

    modalCancelBtn.addEventListener('click', closeModal);
    document.getElementById('itemForm').addEventListener('submit', function(e) {
      e.preventDefault();
      saveItem();
    });
    itemModal.addEventListener('click', e => { if (e.target === itemModal) closeModal(); });

    document.getElementById('categoryModalCancelBtn').addEventListener('click', closeCategoryModal);
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
      e.preventDefault();
      saveCategory();
    });
    categoryModal.addEventListener('click', e => { if (e.target === categoryModal) closeCategoryModal(); });

    (function initMidiPlayer() {
      const playlist = document.getElementById('midiPlaylistList');
      const musicModal = document.getElementById('musicControlsModal');
      const urlInput = document.getElementById('midiUrlInput');
      const nameInput = document.getElementById('midiNameInput');
      const addUrlBtn = document.getElementById('midiAddUrlBtn');
      const fileInput = document.getElementById('midiFileInput');
      const musicModalCloseBtn = document.getElementById('musicModalCloseBtn');
      const musicCharmBtn = document.getElementById('musicCharmBtn');
      const playlistEmpty = document.getElementById('midiPlaylistEmpty');
      const playBtn = document.getElementById('midiPlayBtn');
      const pauseBtn = document.getElementById('midiPauseBtn');
      const prevBtn = document.getElementById('midiPrevBtn');
      const nextBtn = document.getElementById('midiNextBtn');
      const trackNameEl = document.getElementById('midiTrackName');
      const shuffleBtn = document.getElementById('midiShuffleBtn');
      const repeatOneBtn = document.getElementById('midiRepeatOneBtn');
      const repeatAllBtn = document.getElementById('midiRepeatAllBtn');
      const progressBar = document.getElementById('midiProgressBar');
      const progressFill = document.getElementById('midiProgressFill');
      const progressTime = document.getElementById('midiProgressTime');

      function formatMidiTime(sec) {
        if (sec == null || !isFinite(sec) || sec < 0) return '0:00';
        var m = Math.floor(sec / 60);
        var s = Math.floor(sec % 60);
        return m + ':' + (s < 10 ? '0' : '') + s;
      }
      function updateProgressBar() {
        var current = midiCurrentTime;
        var total = midiSong ? midiSong.duration : 0;
        var pct = total > 0 ? Math.min(100, (current / total) * 100) : 0;
        if (progressFill) progressFill.style.width = pct + '%';
        if (progressTime) progressTime.textContent = formatMidiTime(current) + ' / ' + formatMidiTime(total);
        if (progressBar) progressBar.setAttribute('aria-valuenow', Math.round(pct));
      }

      function loadMidiMode() {
        var s = localStorage.getItem('devStartPageMidiShuffle') === '1';
        var o = localStorage.getItem('devStartPageMidiRepeatOne') === '1';
        var a = localStorage.getItem('devStartPageMidiRepeatAll');
        if (a === null) a = true; else a = a === '1';
        if (s && !o && !a) { midiShuffle = true; midiRepeatOne = false; midiRepeatAll = false; }
        else if (!s && o && !a) { midiShuffle = false; midiRepeatOne = true; midiRepeatAll = false; }
        else { midiShuffle = false; midiRepeatOne = false; midiRepeatAll = true; }
      }
      function saveMidiMode() {
        localStorage.setItem('devStartPageMidiShuffle', midiShuffle ? '1' : '0');
        localStorage.setItem('devStartPageMidiRepeatOne', midiRepeatOne ? '1' : '0');
        localStorage.setItem('devStartPageMidiRepeatAll', midiRepeatAll ? '1' : '0');
      }
      function updateModeButtons() {
        if (shuffleBtn) {
          shuffleBtn.classList.toggle('active', midiShuffle);
          shuffleBtn.setAttribute('aria-pressed', String(midiShuffle));
        }
        if (repeatOneBtn) {
          repeatOneBtn.classList.toggle('active', midiRepeatOne);
          repeatOneBtn.setAttribute('aria-pressed', String(midiRepeatOne));
        }
        if (repeatAllBtn) {
          repeatAllBtn.classList.toggle('active', midiRepeatAll);
          repeatAllBtn.setAttribute('aria-pressed', String(midiRepeatAll));
        }
      }
      let midiShuffle = false;
      let midiRepeatOne = false;
      let midiRepeatAll = true;
      loadMidiMode();
      updateModeButtons();

      let midiContext = null;
      let midiPlayer = null;
      let midiInput = null;
      let midiRaf = null;
      let midiSong = null;
      let midiSongStart = 0;
      let midiCurrentTime = 0;
      let midiStepDuration = 44 / 1000;
      let midiPlaying = false;
      let midiOnEnded = null;
      let wasPlayingBeforeTabHide = false;
      let resumeFromTime = 0;

      function getPlaylist() {
        return (data.midiPlaylist || []).sort((a, b) => (a.order ?? 0) - (b.order ?? 0));
      }

      function updateTrackDisplay() {
        const tracks = getPlaylist();
        const idx = typeof midiCurrentTrackIndex === 'number' ? midiCurrentTrackIndex : 0;
        const track = tracks[idx];
        trackNameEl.textContent = track ? (track.name || track.url) : '—';
        updateScreensaverMidiTrack();
      }

      function updateScreensaverMidiTrack() {
        var el = document.getElementById('screensaverMidiTrack');
        if (!el) return;
        if (midiPlaying) {
          var tracks = getPlaylist();
          var track = tracks[midiCurrentTrackIndex];
          el.textContent = track ? 'Now playing: ' + (track.name || track.url) : '';
          el.style.display = track ? '' : 'none';
        } else {
          el.textContent = '';
          el.style.display = 'none';
        }
      }

      function updateMusicCharmIcon() {
        var btn = document.getElementById('musicCharmBtn');
        if (!btn) return;
        if (midiPlaying) {
          var tracks = getPlaylist();
          var track = tracks[midiCurrentTrackIndex];
          var trackName = track ? (track.name || track.url) : '';
          btn.textContent = '\u25B6';
          btn.classList.add('music-charm-playing');
          btn.title = trackName ? 'Now playing: ' + trackName : 'Music controls';
          btn.setAttribute('aria-label', trackName ? 'Now playing: ' + trackName : 'Music controls');
        } else {
          btn.textContent = '\u266A';
          btn.classList.remove('music-charm-playing');
          btn.title = 'Music controls';
          btn.setAttribute('aria-label', 'Music controls');
        }
      }

      let midiCurrentTrackIndex = 0;
      let lastMidiResumeSave = 0;
      let pendingResumeOnInteraction = false;

      function saveMidiResumeState() {
        try {
          var tracks = getPlaylist();
          if (tracks.length === 0) return;
          var idx = Math.max(0, Math.min(midiCurrentTrackIndex, tracks.length - 1));
          localStorage.setItem('devStartPageMidiTrackIndex', String(idx));
          localStorage.setItem('devStartPageMidiPosition', String(midiCurrentTime));
          localStorage.setItem('devStartPageMidiWasPlaying', midiPlaying ? '1' : '0');
        } catch (e) {}
      }
      function tryRestoreMidiPlayback() {
        if (window._midiRestoreAttempted) return;
        window._midiRestoreAttempted = true;
        try {
          var wasPlaying = localStorage.getItem('devStartPageMidiWasPlaying') === '1';
          var idxStr = localStorage.getItem('devStartPageMidiTrackIndex');
          var posStr = localStorage.getItem('devStartPageMidiPosition');
          var tracks = getPlaylist();
          if (tracks.length === 0 || idxStr == null) return;
          var idx = Math.max(0, Math.min(parseInt(idxStr, 10) || 0, tracks.length - 1));
          var pos = parseFloat(posStr) || 0;
          if (pos < 0) pos = 0;
          midiCurrentTrackIndex = idx;
          if (wasPlaying) {
            pendingResumeOnInteraction = true;
            playCurrent(pos, true);
            function doResumeOnInteraction() {
              if (!pendingResumeOnInteraction) return;
              if (!midiSong) return;
              pendingResumeOnInteraction = false;
              document.removeEventListener('click', doResumeOnInteraction, true);
              document.removeEventListener('mousedown', doResumeOnInteraction, true);
              document.removeEventListener('keydown', doResumeOnInteraction, true);
              document.removeEventListener('touchstart', doResumeOnInteraction, true);
              if (midiPlaying) {
                if (midiContext && midiContext.state === 'suspended') midiContext.resume();
                return;
              }
              midiPlaying = true;
              playBtn.style.display = 'none';
              pauseBtn.style.display = '';
              updateScreensaverMidiTrack();
              updateMusicCharmIcon();
              if (midiContext) {
                midiContext.resume().then(function() { midiRaf = requestAnimationFrame(tick); });
              } else {
                midiRaf = requestAnimationFrame(tick);
              }
            }
            document.addEventListener('click', doResumeOnInteraction, true);
            document.addEventListener('mousedown', doResumeOnInteraction, true);
            document.addEventListener('keydown', doResumeOnInteraction, true);
            document.addEventListener('touchstart', doResumeOnInteraction, true);
          } else {
            playCurrent(pos, false);
          }
        } catch (e) {}
      }

      var SOUNDBLASTER_BASE = 'https://surikov.github.io/webaudiofontdata/sound/';
      function preferSoundBlasterInstrument(loader, program) {
        if (loader.instrumentKeys) {
          try {
            var keys = loader.instrumentKeys(program);
            if (keys && keys.length) {
              for (var k = 0; k < keys.length; k++) {
                try {
                  var inf = loader.instrumentInfo(keys[k]);
                  if (inf && inf.variable && inf.variable.indexOf('SoundBlasterOld') >= 0) return inf;
                } catch (e2) {}
              }
            }
          } catch (e) {}
        }
        var id = String((program || 0) * 10).padStart(4, '0');
        return { url: SOUNDBLASTER_BASE + id + '_SoundBlasterOld_sf2.js', variable: '_tone_' + id + '_SoundBlasterOld_sf2' };
      }
      function preferSoundBlasterDrum(loader, drumNote) {
        if (loader.drumKeys) {
          try {
            var keys = loader.drumKeys(drumNote);
            if (keys && keys.length) {
              for (var k = 0; k < keys.length; k++) {
                try {
                  var inf = loader.drumInfo(keys[k]);
                  if (inf && inf.variable && inf.variable.indexOf('SoundBlasterOld') >= 0) return inf;
                } catch (e2) {}
              }
            }
          } catch (e) {}
        }
        try {
          var nn = loader.findDrum(drumNote);
          return loader.drumInfo(nn);
        } catch (e) {
          var did = String(Math.min(127, Math.max(0, drumNote || 0))).padStart(4, '0');
          return { url: SOUNDBLASTER_BASE + did + '_SoundBlasterOld_sf2.js', variable: '_tone_' + did + '_SoundBlasterOld_sf2' };
        }
      }

      function sendNotes(song, songStart, start, end) {
        if (!midiPlayer || !midiInput || !midiSong) return;
        for (let t = 0; t < song.tracks.length; t++) {
          const track = song.tracks[t];
          for (let i = 0; i < track.notes.length; i++) {
            if (track.notes[i].when >= start && track.notes[i].when < end) {
              const when = songStart + track.notes[i].when;
              let duration = track.notes[i].duration;
              if (duration > 3) duration = 3;
              const instr = track.info.variable;
              const v = track.volume / 7;
              midiPlayer.queueWaveTable(midiContext, midiInput, window[instr], when, track.notes[i].pitch, duration, v, track.notes[i].slides);
            }
          }
        }
        for (let b = 0; b < song.beats.length; b++) {
          const beat = song.beats[b];
          for (let i = 0; i < beat.notes.length; i++) {
            if (beat.notes[i].when >= start && beat.notes[i].when < end) {
              const when = songStart + beat.notes[i].when;
              const instr = beat.info.variable;
              const v = beat.volume / 2;
              midiPlayer.queueWaveTable(midiContext, midiInput, window[instr], when, beat.n, 1.5, v);
            }
          }
        }
      }

      function tick() {
        if (!midiPlaying || !midiSong) return;
        if (midiContext.currentTime > midiSongStart + midiCurrentTime - midiStepDuration) {
          const start = midiCurrentTime;
          midiCurrentTime += midiStepDuration;
          if (midiCurrentTime > midiSong.duration) {
            midiPlaying = false;
            if (midiPlayer && midiContext) midiPlayer.cancelQueue(midiContext);
            pauseBtn.style.display = 'none';
            playBtn.style.display = '';
            updateScreensaverMidiTrack();
            updateMusicCharmIcon();
            if (midiOnEnded) midiOnEnded();
            return;
          }
          sendNotes(midiSong, midiSongStart, start, midiCurrentTime);
        }
        updateProgressBar();
        if (midiPlaying && Date.now() - lastMidiResumeSave > 2000) {
          lastMidiResumeSave = Date.now();
          saveMidiResumeState();
        }
        midiRaf = requestAnimationFrame(tick);
      }

      function loadAndPlayMidi(url, startTime, autoPlay) {
        if (!window.MIDIFile || !window.WebAudioFontPlayer) return;
        var resumeAt = typeof startTime === 'number' && startTime > 0 ? startTime : 0;
        if (autoPlay === undefined) autoPlay = true;
        fetch(url).then(r => r.arrayBuffer()).then(function(arrayBuffer) {
          var midiFile = new window.MIDIFile(arrayBuffer);
          var song = midiFile.parseSong();
          midiContext = midiContext || new (window.AudioContext || window.webkitAudioContext)();
          midiPlayer = midiPlayer || new window.WebAudioFontPlayer();
          var equalizer = midiPlayer.createChannel(midiContext);
          midiInput = equalizer.input;
          equalizer.output.connect(midiContext.destination);
          var loader = midiPlayer.loader;
          for (var i = 0; i < song.tracks.length; i++) {
            var info = preferSoundBlasterInstrument(loader, song.tracks[i].program);
            song.tracks[i].info = info;
            loader.startLoad(midiContext, info.url, info.variable);
          }
          for (var i = 0; i < song.beats.length; i++) {
            var info = preferSoundBlasterDrum(loader, song.beats[i].n);
            song.beats[i].info = info;
            loader.startLoad(midiContext, info.url, info.variable);
          }
          midiPlayer.loader.waitLoad(function() {
            midiContext.resume();
            midiSong = song;
            resumeAt = Math.min(resumeAt, Math.max(0, song.duration - 0.001));
            midiSongStart = midiContext.currentTime - resumeAt;
            midiCurrentTime = resumeAt;
            midiPlaying = !!autoPlay;
            playBtn.style.display = autoPlay ? 'none' : '';
            pauseBtn.style.display = autoPlay ? '' : 'none';
            updateScreensaverMidiTrack();
            updateMusicCharmIcon();
            updateProgressBar();
            if (autoPlay) midiRaf = requestAnimationFrame(tick);
          });
        }).catch(function(err) {
          console.error('MIDI load error:', err);
          alert('Could not load MIDI file. Check the URL or CORS.');
        });
      }

      function stopMidi(skipSave) {
        midiPlaying = false;
        if (midiRaf) cancelAnimationFrame(midiRaf);
        midiRaf = null;
        if (midiPlayer && midiContext) midiPlayer.cancelQueue(midiContext);
        pauseBtn.style.display = 'none';
        playBtn.style.display = '';
        if (!skipSave) saveMidiResumeState();
        updateScreensaverMidiTrack();
        updateMusicCharmIcon();
        updateProgressBar();
      }

      function playCurrent(startTime, autoPlay) {
        const tracks = getPlaylist();
        if (tracks.length === 0) return;
        midiCurrentTrackIndex = Math.max(0, Math.min(midiCurrentTrackIndex, tracks.length - 1));
        const track = tracks[midiCurrentTrackIndex];
        var base = window.location.href.split('/').slice(0, -1).join('/') + '/';
        var url = track.url.startsWith('http') ? track.url : (base + track.url.replace(/^\//, ''));
        updateTrackDisplay();
        loadAndPlayMidi(url, startTime, autoPlay);
      }

      midiOnEnded = function() {
        const tracks = getPlaylist();
        if (tracks.length === 0) return;
        if (midiRepeatOne) {
          playCurrent();
          return;
        }
        if (midiShuffle) {
          if (tracks.length > 1) {
            let next = Math.floor(Math.random() * tracks.length);
            while (next === midiCurrentTrackIndex) next = Math.floor(Math.random() * tracks.length);
            midiCurrentTrackIndex = next;
          }
        } else {
          const atLast = midiCurrentTrackIndex >= tracks.length - 1;
          if (atLast && !midiRepeatAll) {
            stopMidi();
            return;
          }
          midiCurrentTrackIndex = (midiCurrentTrackIndex + 1) % tracks.length;
        }
        playCurrent();
      };

      playBtn.addEventListener('click', function() {
        if (pendingResumeOnInteraction && midiSong) return;
        const tracks = getPlaylist();
        if (tracks.length === 0) { if (musicModal) musicModal.classList.add('open'); return; }
        playCurrent();
      });
      pauseBtn.addEventListener('click', stopMidi);
      prevBtn.addEventListener('click', function() {
        stopMidi();
        const tracks = getPlaylist();
        if (tracks.length === 0) return;
        midiCurrentTrackIndex = (midiCurrentTrackIndex - 1 + tracks.length) % tracks.length;
        playCurrent();
      });
      nextBtn.addEventListener('click', function() {
        stopMidi();
        const tracks = getPlaylist();
        if (tracks.length === 0) return;
        if (midiShuffle && tracks.length > 1) {
          let next = Math.floor(Math.random() * tracks.length);
          while (next === midiCurrentTrackIndex) next = Math.floor(Math.random() * tracks.length);
          midiCurrentTrackIndex = next;
        } else if (!midiShuffle) {
          midiCurrentTrackIndex = (midiCurrentTrackIndex + 1) % tracks.length;
        }
        playCurrent();
      });

      if (shuffleBtn) {
        shuffleBtn.addEventListener('click', function() {
          if (midiShuffle) return;
          midiShuffle = true;
          midiRepeatOne = false;
          midiRepeatAll = false;
          saveMidiMode();
          updateModeButtons();
        });
      }
      if (repeatOneBtn) {
        repeatOneBtn.addEventListener('click', function() {
          if (midiRepeatOne) return;
          midiShuffle = false;
          midiRepeatOne = true;
          midiRepeatAll = false;
          saveMidiMode();
          updateModeButtons();
        });
      }
      if (repeatAllBtn) {
        repeatAllBtn.addEventListener('click', function() {
          if (midiRepeatAll) return;
          midiShuffle = false;
          midiRepeatOne = false;
          midiRepeatAll = true;
          saveMidiMode();
          updateModeButtons();
        });
      }

      if (progressBar) {
        progressBar.addEventListener('click', function(e) {
          const tracks = getPlaylist();
          if (tracks.length === 0 || !midiSong) return;
          const rect = progressBar.getBoundingClientRect();
          const pct = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
          const seekTime = pct * midiSong.duration;
          const wasPlaying = midiPlaying;
          stopMidi();
          playCurrent(seekTime, wasPlaying);
        });
        progressBar.addEventListener('keydown', function(e) {
          if (!midiSong || !progressBar.getAttribute('aria-valuenow')) return;
          const step = e.shiftKey ? 10 : 1;
          let pct = parseInt(progressBar.getAttribute('aria-valuenow') || '0', 10);
          if (e.key === 'ArrowLeft' || e.key === 'Home') pct = e.key === 'Home' ? 0 : Math.max(0, pct - step);
          else if (e.key === 'ArrowRight' || e.key === 'End') pct = e.key === 'End' ? 100 : Math.min(100, pct + step);
          else return;
          const seekTime = (pct / 100) * midiSong.duration;
          const wasPlaying = midiPlaying;
          stopMidi();
          playCurrent(seekTime, wasPlaying);
          e.preventDefault();
        });
      }

      function renderPlaylist() {
        const tracks = getPlaylist();
        playlistEmpty.style.display = tracks.length === 0 ? 'block' : 'none';
        playlist.innerHTML = tracks.map(function(t, i) {
          return '<div class="time-block-row" data-id="' + escapeHtml(t.id) + '" data-index="' + i + '"><span>' + escapeHtml(t.name || t.url) + '</span><button class="tb-delete" type="button">Remove</button></div>';
        }).join('');
        playlist.querySelectorAll('.time-block-row').forEach(function(row) {
          row.addEventListener('click', function(e) {
            if (e.target.closest('.tb-delete')) return;
            var idx = parseInt(row.dataset.index, 10);
            if (isNaN(idx) || idx < 0) return;
            midiCurrentTrackIndex = idx;
            stopMidi();
            playCurrent();
          });
        });
        playlist.querySelectorAll('.tb-delete').forEach(function(btn) {
          btn.addEventListener('click', function(e) {
            e.stopPropagation();
            api('removeMidiTrack', { id: btn.closest('.time-block-row').dataset.id }).then(function() {
              data.midiPlaylist = (data.midiPlaylist || []).filter(function(x) { return x.id !== btn.closest('.time-block-row').dataset.id; });
              renderPlaylist();
              updateTrackDisplay();
              updateNavButtons();
            }).catch(function(e) { alert('Failed: ' + (e.message || 'Unknown')); });
          });
        });
      }

      if (musicCharmBtn) {
        musicCharmBtn.addEventListener('click', function() {
          renderPlaylist();
          updateProgressBar();
          if (musicModal) musicModal.classList.add('open');
        });
      }
      if (musicModalCloseBtn) musicModalCloseBtn.addEventListener('click', function() { if (musicModal) musicModal.classList.remove('open'); });
      if (musicModal) musicModal.addEventListener('click', function(e) { if (e.target === musicModal) musicModal.classList.remove('open'); });

      window.addEventListener('pagehide', saveMidiResumeState);

      document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
          if (midiPlaying) {
            resumeFromTime = midiCurrentTime;
            saveMidiResumeState();
            stopMidi(true);
            wasPlayingBeforeTabHide = true;
          }
        } else {
          if (wasPlayingBeforeTabHide) {
            wasPlayingBeforeTabHide = false;
            var timeToResume = resumeFromTime;
            resumeFromTime = 0;
            playCurrent(timeToResume);
          }
        }
      });

      addUrlBtn.addEventListener('click', function() {
        var url = urlInput.value.trim();
        var name = nameInput.value.trim();
        if (!url) { alert('Enter a MIDI URL or path'); return; }
        api('addMidiTrack', { url: url, name: name || undefined }).then(function(res) {
          if (res && res.track) {
            data.midiPlaylist = data.midiPlaylist || [];
            data.midiPlaylist.push(res.track);
            urlInput.value = '';
            nameInput.value = '';
            renderPlaylist();
            updateTrackDisplay();
            updateNavButtons();
          }
        }).catch(function(e) { alert('Failed: ' + (e.message || 'Unknown')); });
      });

      fileInput.addEventListener('change', function(e) {
        var file = e.target.files && e.target.files[0];
        if (!file) return;
        var fd = new FormData();
        fd.append('file', file);
        fd.append('action', 'uploadMidi');
        fetch('api.php?action=uploadMidi', { method: 'POST', body: fd }).then(function(r) { return r.json(); }).then(function(res) {
          if (res && res.success && res.url) {
            api('addMidiTrack', { url: res.url, name: res.name || file.name.replace(/\.(mid|midi)$/i, '') }).then(function(apiRes) {
              if (apiRes && apiRes.track) {
                data.midiPlaylist = data.midiPlaylist || [];
                data.midiPlaylist.push(apiRes.track);
                renderPlaylist();
                updateTrackDisplay();
                updateNavButtons();
              }
            });
          } else {
            alert(res && res.error ? res.error : 'Upload failed');
          }
          e.target.value = '';
        }).catch(function(err) { alert('Upload failed'); e.target.value = ''; });
      });

      function updateNavButtons() {
        var tracks = getPlaylist();
        prevBtn.disabled = nextBtn.disabled = tracks.length === 0;
      }

      window._midiPlayerRefresh = function() {
        updateTrackDisplay();
        updateNavButtons();
      };
      window._midiPlayerTryRestore = tryRestoreMidiPlayback;
      window._midiPlayerUpdateScreensaverTrack = updateScreensaverMidiTrack;

      updateTrackDisplay();
      updateNavButtons();
      updateMusicCharmIcon();
    })();

    render();
    load();
  })();
  </script>
</body>
</html>
