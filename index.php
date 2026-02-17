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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Silkscreen:wght@400;700&family=Orbitron:wght@400;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@300;400;500;600;700&family=VT323&family=Pixelify+Sans:wght@400;700&family=Antonio:wght@400;600;700&display=swap" rel="stylesheet">
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
    --palette-1: #00cc66;
    --palette-2: #0088ff;
    --palette-3: #ffaa00;
    --game-board-bg: #1a1630;
    --game-piece: #00cc66;
    --game-piece-light: #4a4480;
    --game-border: #4a4480;
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
      --palette-1: #00ff88;
      --palette-2: #00d4ff;
      --palette-3: #ff00aa;
      --game-board-bg: #0a0e17;
      --game-piece: #00ffff;
      --game-piece-light: #00e5ff;
      --game-border: #00ffff;
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
      --palette-1: #00ff88;
      --palette-2: #ff3366;
      --palette-3: #ff0066;
      --game-board-bg: #170a0a;
      --game-piece: #ff0040;
      --game-piece-light: #ff3366;
      --game-border: #ff0040;
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
      --palette-1: #00ff41;
      --palette-2: #33ff66;
      --palette-3: #00cc34;
      --game-board-bg: #0d0d0d;
      --game-piece: #00ff41;
      --game-piece-light: #33ff66;
      --game-border: #00ff41;
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
      --palette-1: #00aaff;
      --palette-2: #33bbff;
      --palette-3: #ff8844;
      --game-board-bg: #181830;
      --game-piece: #00aaff;
      --game-piece-light: #33bbff;
      --game-border: #4040a0;
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
      --palette-1: #00c853;
      --palette-2: #006fcd;
      --palette-3: #ffab00;
      --game-board-bg: #0c0c0c;
      --game-piece: #00c853;
      --game-piece-light: #006fcd;
      --game-border: rgba(255,255,255,0.12);
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
      --palette-1: #306230;
      --palette-2: #0f380f;
      --palette-3: #506230;
      --game-board-bg: #0f380f;
      --game-piece: #8bac0f;
      --game-piece-light: #9bbc0f;
      --game-border: #306230;
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
      --palette-1: #000000;
      --palette-2: #000000;
      --palette-3: #000000;
      --game-board-bg: #ffffff;
      --game-piece: #000000;
      --game-piece-light: #000000;
      --game-border: #000000;
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
      --palette-1: #00a000;
      --palette-2: #0000aa;
      --palette-3: #aa5500;
      --game-board-bg: #000000;
      --game-piece: #00a000;
      --game-piece-light: #00a000;
      --game-border: #808080;
    }

    /* Catppuccin Mocha theme (dark) – Hyprland-style */
    html[data-theme="catppuccin"] {
      --bg: #1e1e2e;
      --bg-alt: #181825;
      --content: #cdd6f4;
      --content-muted: #bac2de;
      --button-bg: #89b4fa;
      --button-hover: #b4befe;
      --button-fg: #1e1e2e;
      --card-bg: #313244;
      --card-border: #45475a;
      --bevel-light: #585b70;
      --bevel-dark: #11111b;
      --edit-btn-bg: #89b4fa;
      --edit-btn-fg: #1e1e2e;
      --edit-btn-border: #b4befe;
      --edit-btn-hover: #b4befe;
      --delete-btn-bg: #f38ba8;
      --delete-btn-fg: #1e1e2e;
      --delete-btn-border: #eba0ac;
      --delete-btn-hover: #eba0ac;
      --palette-1: #a6e3a1;
      --palette-2: #89b4fa;
      --palette-3: #f9e2af;
      --game-board-bg: #1e1e2e;
      --game-piece: #a6e3a1;
      --game-piece-light: #89b4fa;
      --game-border: #45475a;
    }

    /* Catppuccin Latte theme (light) – Hyprland-style */
    html[data-theme="catppuccin-latte"] {
      --bg: #eff1f5;
      --bg-alt: #e6e9ef;
      --content: #4c4f69;
      --content-muted: #5c5f77;
      --button-bg: #1e66f5;
      --button-hover: #3584e4;
      --button-fg: #ffffff;
      --card-bg: #ccd0da;
      --card-border: #bcc0cc;
      --bevel-light: #acb0be;
      --bevel-dark: #9ca0b0;
      --edit-btn-bg: #1e66f5;
      --edit-btn-fg: #ffffff;
      --edit-btn-border: #3584e4;
      --edit-btn-hover: #3584e4;
      --delete-btn-bg: #d20f39;
      --delete-btn-fg: #ffffff;
      --delete-btn-border: #e64553;
      --delete-btn-hover: #e64553;
      --palette-1: #40a02b;
      --palette-2: #1e66f5;
      --palette-3: #df8e1d;
      --game-board-bg: #2D353B;
      --game-piece: #A7C080;
      --game-piece-light: #7FBBB3;
      --game-border: #3D484D;
    }

    /* Everforest theme (dark) */
    html[data-theme="everforest"] {
      --bg: #2D353B;
      --bg-alt: #232A2E;
      --content: #D3C6AA;
      --content-muted: #859289;
      --button-bg: #A7C080;
      --button-hover: #83C092;
      --button-fg: #2D353B;
      --card-bg: #343F44;
      --card-border: #3D484D;
      --bevel-light: #475258;
      --bevel-dark: #1E2326;
      --edit-btn-bg: #A7C080;
      --edit-btn-fg: #2D353B;
      --edit-btn-border: #83C092;
      --edit-btn-hover: #83C092;
      --delete-btn-bg: #E67E80;
      --delete-btn-fg: #2D353B;
      --delete-btn-border: #E69875;
      --delete-btn-hover: #E69875;
      --palette-1: #A7C080;
      --palette-2: #7FBBB3;
      --palette-3: #DBBC7F;
      --game-board-bg: #2D353B;
      --game-piece: #A7C080;
      --game-piece-light: #7FBBB3;
      --game-border: #3D484D;
    }

    /* Tokyo Night theme (dark) */
    html[data-theme="tokyo-night"] {
      --bg: #1a1b26;
      --bg-alt: #16161e;
      --content: #c0caf5;
      --content-muted: #a9b1d6;
      --button-bg: #7aa2f7;
      --button-hover: #7dcfff;
      --button-fg: #1a1b26;
      --card-bg: #24283b;
      --card-border: #414868;
      --bevel-light: #565f89;
      --bevel-dark: #16161e;
      --edit-btn-bg: #7aa2f7;
      --edit-btn-fg: #1a1b26;
      --edit-btn-border: #7dcfff;
      --edit-btn-hover: #7dcfff;
      --delete-btn-bg: #f7768e;
      --delete-btn-fg: #1a1b26;
      --delete-btn-border: #ff9e64;
      --delete-btn-hover: #ff9e64;
      --palette-1: #9ece6a;
      --palette-2: #7dcfff;
      --palette-3: #e0af68;
      --game-board-bg: #1a1b26;
      --game-piece: #9ece6a;
      --game-piece-light: #7dcfff;
      --game-border: #414868;
    }

    /* Star Trek: The Next Generation / LCARS theme */
    html[data-theme="lcars"] {
      --bg: #0a0a12;
      --bg-alt: #12121a;
      --content: #ff9900;
      --content-muted: #cc7700;
      --button-bg: #ff8800;
      --button-hover: #ffaa33;
      --button-fg: #0a0a12;
      --card-bg: rgba(255, 136, 0, 0.08);
      --card-border: #ff8800;
      --bevel-light: rgba(255, 136, 0, 0.35);
      --bevel-dark: #050508;
      --edit-btn-bg: #ff8800;
      --edit-btn-fg: #0a0a12;
      --edit-btn-border: #ffaa33;
      --edit-btn-hover: #ffaa33;
      --delete-btn-bg: #cc4400;
      --delete-btn-fg: #0a0a12;
      --delete-btn-border: #ff6644;
      --delete-btn-hover: #ff6644;
      --palette-1: #ffaa33;
      --palette-2: #8899ff;
      --palette-3: #cc99ff;
      --game-board-bg: #0a0a12;
      --game-piece: #ff9900;
      --game-piece-light: #ffaa33;
      --game-border: #ff8800;
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
    html[data-theme="lcars"] body,
    html[data-theme="lcars"] * {
      font-family: 'Antonio', sans-serif;
    }
    html[data-theme="lcars"] body {
      background: linear-gradient(180deg, #0a0a12 0%, #12121a 50%, #0a0a12 100%);
      background-attachment: fixed;
    }
    html[data-theme="catppuccin"] body,
    html[data-theme="catppuccin"] * {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="catppuccin"] body {
      background: linear-gradient(180deg, #1e1e2e 0%, #181825 50%, #11111b 100%);
      background-attachment: fixed;
    }
    html[data-theme="catppuccin-latte"] body,
    html[data-theme="catppuccin-latte"] * {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="catppuccin-latte"] body {
      background: linear-gradient(180deg, #eff1f5 0%, #e6e9ef 50%, #dce0e8 100%);
      background-attachment: fixed;
    }
    html[data-theme="everforest"] body,
    html[data-theme="everforest"] * {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="everforest"] body {
      background: linear-gradient(180deg, #2D353B 0%, #232A2E 50%, #1E2326 100%);
      background-attachment: fixed;
    }
    html[data-theme="tokyo-night"] body,
    html[data-theme="tokyo-night"] * {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    html[data-theme="tokyo-night"] body {
      background: linear-gradient(180deg, #1a1b26 0%, #16161e 50%, #13141a 100%);
      background-attachment: fixed;
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
      justify-content: flex-end;
      gap: 0.35rem;
      align-items: stretch;
      z-index: 100;
    }
    .charms-tray {
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
      align-items: stretch;
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      pointer-events: none;
      transform: translateY(0.5rem);
      transition: max-height 0.25s ease, opacity 0.2s ease, transform 0.2s ease;
    }
    .charms-menu:hover .charms-tray,
    .charms-menu:focus-within .charms-tray {
      max-height: 20rem;
      opacity: 1;
      pointer-events: auto;
      transform: translateY(0);
      overflow: visible;
    }
    .charms-hamburger {
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
      font-size: 1.1rem;
      font-family: inherit;
      opacity: 0.85;
      box-shadow: 2px 2px 0 var(--bevel-dark), inset 1px 1px 0 var(--bevel-light);
      transition: opacity 0.15s, background 0.15s;
    }
    .charms-hamburger:hover { opacity: 1; background: var(--card-border); }
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
      display: none;
      flex-direction: column;
      z-index: 101;
    }
    .theme-dropdown.open { display: flex; }
    .theme-dropdown-options {
      overflow-y: auto;
      flex: 1;
      min-height: 0;
      scrollbar-color: var(--card-border) var(--bevel-dark);
      scrollbar-width: thin;
    }
    .theme-dropdown-options::-webkit-scrollbar {
      width: 8px;
    }
    .theme-dropdown-options::-webkit-scrollbar-track {
      background: var(--bevel-dark);
    }
    .theme-dropdown-options::-webkit-scrollbar-thumb {
      background: var(--card-border);
      border: 2px solid var(--bevel-dark);
      border-radius: 2px;
    }
    .theme-dropdown-options::-webkit-scrollbar-thumb:hover {
      background: var(--button-bg);
    }
    .theme-dropdown-header {
      padding: 0.4rem 0.6rem;
      font-size: 0.65rem;
      color: var(--content-muted);
      font-family: 'Silkscreen', monospace;
      border-bottom: 2px solid var(--card-border);
      background: var(--bg-alt);
      white-space: nowrap;
      flex-shrink: 0;
    }
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

    /* Charm tooltips only – instant show, in-theme */
    .charms-menu [data-tooltip] {
      position: relative;
    }
    .charms-menu [data-tooltip]::after {
      content: attr(data-tooltip);
      position: absolute;
      left: 100%;
      bottom: 50%;
      margin-left: 0.4rem;
      transform: translateY(50%);
      padding: 0.25rem 0.55rem;
      font-size: 0.68rem;
      font-family: inherit;
      letter-spacing: 0.04em;
      white-space: nowrap;
      color: var(--content);
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      box-shadow: 2px 2px 0 var(--bevel-dark), inset 1px 1px 0 var(--bevel-light);
      pointer-events: none;
      z-index: 1001;
      opacity: 0;
      visibility: hidden;
      transition: none;
    }
    .charms-menu [data-tooltip]:hover::after {
      opacity: 1;
      visibility: visible;
      transition: none;
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
      aspect-ratio: 4/2;
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

    .link-card--accent1 { border-left: 5px solid var(--palette-1); }
    .link-card--accent1:hover { border-left-color: var(--palette-1); }
    .link-card--accent2 { border-left: 5px solid var(--palette-2); }
    .link-card--accent2:hover { border-left-color: var(--palette-2); }
    .link-card--accent3 { border-left: 5px solid var(--palette-3); }
    .link-card--accent3:hover { border-left-color: var(--palette-3); }

    .link-card-content .link-title {
      display: -webkit-box;
      -webkit-line-clamp: 2; -webkit-box-orient: vertical;
      line-height: 1.25; min-height: 1.5em;
      overflow: hidden; text-overflow: ellipsis;
    }
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
    .color-select-wrap { position: relative; margin-bottom: 0.75rem; }
    .color-select-trigger {
      display: flex; align-items: center; gap: 0.5rem;
      width: 100%; padding: 0.5rem;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      color: var(--content);
      font-size: 0.9rem; font-family: inherit;
      box-shadow: inset 2px 2px 0 rgba(0,0,0,0.3);
      cursor: pointer; text-align: left;
    }
    .color-select-trigger:hover, .color-select-trigger:focus {
      border-color: var(--button-bg);
      outline: none;
    }
    .color-swatch {
      display: inline-block;
      width: 1rem; height: 1rem;
      flex-shrink: 0;
      border: 1px solid rgba(0,0,0,0.2);
      border-radius: 2px;
    }
    .color-swatch--none {
      background: repeating-linear-gradient(-45deg, var(--card-border), var(--card-border) 2px, transparent 2px, transparent 4px);
      background-size: 6px 6px;
    }
    .color-swatch--accent1 { background: var(--palette-1); }
    .color-swatch--accent2 { background: var(--palette-2); }
    .color-swatch--accent3 { background: var(--palette-3); }
    .color-select-label { flex: 1; }
    .color-select-chevron { font-size: 0.6rem; opacity: 0.7; }
    .color-select-dropdown {
      position: absolute; left: 0; right: 0; top: 100%; margin-top: 2px;
      background: var(--bg-alt);
      border: 2px solid var(--card-border);
      box-shadow: 4px 4px 0 var(--bevel-dark);
      z-index: 10;
      max-height: 180px; overflow-y: auto;
    }
    .color-select-dropdown:not([hidden]) { display: block; }
    .color-select-option {
      display: flex; align-items: center; gap: 0.5rem;
      padding: 0.4rem 0.5rem;
      cursor: pointer;
      font-size: 0.9rem; font-family: inherit;
      color: var(--content);
    }
    .color-select-option:hover, .color-select-option:focus {
      background: var(--card-bg);
      outline: none;
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

    .help-modal-content {
      font-size: 0.85rem;
      line-height: 1.5;
      color: var(--content);
    }
    .help-modal-content p { margin: 0 0 0.75rem 0; }
    .help-modal-content p:last-child { margin-bottom: 0; }
    .help-modal-content ul {
      margin: 0 0 0.75rem 0;
      padding-left: 1.25rem;
      list-style: disc;
    }
    .help-modal-content li { margin-bottom: 0.25rem; }
    .help-modal-content li:last-child { margin-bottom: 0; }
    .help-modal-content .help-shortcuts {
      margin-top: 0.5rem;
      padding: 0.5rem 0.6rem;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      font-family: 'JetBrains Mono', monospace;
      font-size: 0.75rem;
    }
    .help-modal-content .help-shortcuts code {
      color: var(--button-bg);
      font-weight: 700;
    }

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
      color: var(--card-border);
      border-color: var(--bg);
    }
    .scratch-pad-stop-btn:hover:not(:disabled) { background: var(--card-border); color: var(--button-fg, var(--content)); }
    .scratch-pad-title { opacity: 0.9; }
    .scratch-pad-body-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 0;
    }
    .scratch-pad-text-editor {
      white-space: pre-wrap;
      word-wrap: break-word;
    }
    .scratch-pad-text-editor:empty::before {
      content: attr(data-placeholder);
      color: var(--content-muted);
      opacity: 0.7;
    }
    .scratch-pad-line {
      display: flex;
      align-items: center;
      flex-wrap: nowrap;
      gap: 0.35rem;
      min-height: 1.4em;
    }
    .scratch-pad-line input[type="checkbox"] {
      flex-shrink: 0;
      width: 1em;
      height: 1em;
      margin: 0;
      vertical-align: middle;
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      border-radius: 2px;
    }
    .scratch-pad-line input[type="checkbox"]:checked {
      background: var(--card-border);
      border-color: var(--card-border);
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M10.3 2.8L4.5 8.6 1.7 5.8 2.8 4.7l1.7 1.7 5.1-5.1 1.1 1.1z'/%3E%3C/svg%3E");
      background-size: 70%;
      background-position: center;
      background-repeat: no-repeat;
    }
    .scratch-pad-line input[type="checkbox"]:checked + .scratch-pad-line-text {
      text-decoration: line-through;
      color: var(--content-muted);
    }
    .scratch-pad-line-text {
      flex: 1;
      min-width: 0;
    }
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
      background: rgba(0, 255, 255, 0.12);
      box-shadow: inset 0 0 20px rgba(0, 255, 255, 0.1), 0 0 15px rgba(0, 255, 255, 0.2);
    }
    html[data-theme="tron"] .link-card--accent1,
    html[data-theme="tron"] .link-card--accent2,
    html[data-theme="tron"] .link-card--accent3 { box-shadow: 0 0 8px rgba(0, 212, 255, 0.3); }
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
      background: rgba(255, 0, 64, 0.12);
      box-shadow: inset 0 0 20px rgba(255, 0, 64, 0.1), 0 0 15px rgba(255, 0, 64, 0.2);
    }
    html[data-theme="tron-ares"] .link-card--accent1 { box-shadow: 0 0 8px rgba(0, 255, 136, 0.3); }
    html[data-theme="tron-ares"] .link-card--accent2,
    html[data-theme="tron-ares"] .link-card--accent3 { box-shadow: 0 0 8px rgba(255, 51, 102, 0.3); }
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
    html[data-theme="gb"] .scratch-pad {
      border-radius: 0;
      border: 3px solid #306230;
      box-shadow: 2px 2px 0 #0f380f, inset 2px 2px 0 rgba(155, 188, 15, 0.2);
    }
    html[data-theme="gb"] .scratch-pad-header {
      border-radius: 0;
      border-bottom: 3px solid #306230;
    }
    html[data-theme="gb"] .scratch-pad-tab {
      background: #8bac0f;
      color: #0f380f;
      border-radius: 0;
      border-width: 2px;
      border-color: #306230;
    }
    html[data-theme="gb"] .scratch-pad-tab:hover { background: #9bbc0f; color: #0f380f; }
    html[data-theme="gb"] .scratch-pad-tab.active { background: #0f380f; color: #9bbc0f; box-shadow: inset 2px 2px 0 #306230; }
    html[data-theme="gb"] .scratch-pad-body {
      border-radius: 0;
      background: #0f380f;
      color: #9bbc0f;
    }
    html[data-theme="gb"] .scratch-pad-body::-webkit-scrollbar { border-radius: 0; }
    html[data-theme="gb"] .scratch-pad-body::-webkit-scrollbar-thumb { border-radius: 0; border: 2px solid #306230; }
    html[data-theme="gb"] .scratch-pad-maximize-btn { border-radius: 0; border-color: #306230; }
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
    html[data-theme="sms"] .scratch-pad {
      border-radius: 0;
      border: 3px solid #4040a0;
      box-shadow: 2px 2px 0 #181830, inset 2px 2px 0 rgba(0, 170, 255, 0.15);
    }
    html[data-theme="sms"] .scratch-pad-header {
      border-radius: 0;
      border-bottom: 3px solid #4040a0;
    }
    html[data-theme="sms"] .scratch-pad-tab {
      background: #202048;
      color: #8098b8;
      border-radius: 0;
      border-width: 2px;
      border-color: #4040a0;
    }
    html[data-theme="sms"] .scratch-pad-tab:hover { background: #282850; color: #b8d4f0; }
    html[data-theme="sms"] .scratch-pad-tab.active { background: #181830; color: #b8d4f0; box-shadow: inset 2px 2px 0 #004466; }
    html[data-theme="sms"] .scratch-pad-body {
      border-radius: 0;
      background: #181830;
      color: #b8d4f0;
    }
    html[data-theme="sms"] .scratch-pad-body::-webkit-scrollbar { border-radius: 0; }
    html[data-theme="sms"] .scratch-pad-body::-webkit-scrollbar-thumb { border-radius: 0; border: 2px solid #4040a0; }
    html[data-theme="sms"] .scratch-pad-maximize-btn { border-radius: 0; border-color: #4040a0; }
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

    /* Catppuccin Mocha component overrides */
    html[data-theme="catppuccin"] .clock {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      letter-spacing: 0.05em;
      color: #cdd6f4;
      text-shadow: none;
    }
    html[data-theme="catppuccin"] h1,
    html[data-theme="catppuccin"] .section-title,
    html[data-theme="catppuccin"] .day-bar-label,
    html[data-theme="catppuccin"] .theme-dropdown-header { font-family: 'Inter', sans-serif; }
    html[data-theme="catppuccin"] .link-card {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border-width: 1px;
      border-color: #45475a;
      background: #313244;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    html[data-theme="catppuccin"] .link-card:hover {
      background: #45475a;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
      transform: translateY(-1px);
    }
    html[data-theme="catppuccin"] .link-card--accent1,
    html[data-theme="catppuccin"] .link-card--accent2,
    html[data-theme="catppuccin"] .link-card--accent3 { border-left-width: 4px; }
    html[data-theme="catppuccin"] .link-icon,
    html[data-theme="catppuccin"] .edit-item-btn,
    html[data-theme="catppuccin"] .delete-item-btn {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="catppuccin"] .link-icon {
      box-shadow: 0 2px 6px rgba(137, 180, 250, 0.3);
    }
    html[data-theme="catppuccin"] .day-bar-track {
      border-radius: 0;
      border-width: 1px;
      border-color: #45475a;
      background: #313244;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="catppuccin"] .day-bar-segment {
      border-radius: 0;
      background: #45475a;
    }
    html[data-theme="catppuccin"] .day-bar-segment.filled {
      background: #89b4fa !important;
      box-shadow: 0 0 12px rgba(137, 180, 250, 0.4);
    }
    html[data-theme="catppuccin"] .add-item-btn,
    html[data-theme="catppuccin"] .add-category-row .add-category-btn,
    html[data-theme="catppuccin"] .link-icon,
    html[data-theme="catppuccin"] .modal .btn-save,
    html[data-theme="catppuccin"] .modal-actions .btn-save {
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 6px rgba(137, 180, 250, 0.3);
    }
    html[data-theme="catppuccin"] .edit-mode-btn {
      border-radius: 0;
      border-width: 2px;
    }
    html[data-theme="catppuccin"] .edit-mode-btn.active {
      box-shadow: 0 0 16px rgba(137, 180, 250, 0.5);
    }
    html[data-theme="catppuccin"] .charms-btn,
    html[data-theme="catppuccin"] .charms-hamburger,
    html[data-theme="catppuccin"] .edit-mode-btn,
    html[data-theme="catppuccin"] .screensaver-btn {
      border-radius: 0;
      border-width: 2px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="catppuccin"] .theme-dropdown {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin"] .theme-dropdown-option { font-family: 'Inter', sans-serif; }
    html[data-theme="catppuccin"] .theme-select {
      background-color: #1e1e2e;
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin"] .theme-select option { background: #1e1e2e; color: #cdd6f4; }
    html[data-theme="catppuccin"] .modal {
      border-radius: 0;
      border-width: 1px;
      border-color: #45475a;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
    }
    html[data-theme="catppuccin"] .modal-actions .btn-cancel,
    html[data-theme="catppuccin"] .modal-actions .btn-save {
      border-radius: 0;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="catppuccin"] .scratch-pad {
      border-radius: 0;
      border-width: 1px;
      border-color: #45475a;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="catppuccin"] .scratch-pad-header {
      background: #45475a;
      color: #cdd6f4;
      font-family: 'Inter', sans-serif;
      border-radius: 0;
    }
    html[data-theme="catppuccin"] .scratch-pad-body {
      background: #181825;
      color: #cdd6f4;
      caret-color: #89b4fa;
      scrollbar-color: #45475a #313244;
    }
    html[data-theme="catppuccin"] .scratch-pad-body::-webkit-scrollbar-track { background: #313244; }
    html[data-theme="catppuccin"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #45475a; border-radius: 0; }
    html[data-theme="catppuccin"] .scratch-pad-body::placeholder { color: rgba(205, 214, 244, 0.4); }
    html[data-theme="catppuccin"] #musicControlsModal input::placeholder { color: rgba(205, 214, 244, 0.4); }
    html[data-theme="catppuccin"] .scratch-pad-tab {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      background: #313244;
      color: #a6adc8;
    }
    html[data-theme="catppuccin"] .scratch-pad-tab:hover { background: #45475a; color: #cdd6f4; }
    html[data-theme="catppuccin"] .scratch-pad-tab.active { background: #1e1e2e; color: #89b4fa; }
    html[data-theme="catppuccin"] .midi-player-widget {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin"] .midi-player-widget .midi-btn {
      border-radius: 0;
    }
    html[data-theme="catppuccin"] .modal input,
    html[data-theme="catppuccin"] .modal select {
      border-radius: 0;
      border-color: #45475a;
      background: #313244;
      box-shadow: none;
    }
    html[data-theme="catppuccin"] .modal input:focus,
    html[data-theme="catppuccin"] .modal select:focus {
      border-color: #89b4fa;
      outline: none;
      box-shadow: 0 0 0 2px rgba(137, 180, 250, 0.3);
    }
    html[data-theme="catppuccin"] .theme-dropdown-option:hover {
      background: #45475a;
      color: #cdd6f4;
    }

    /* Catppuccin Latte component overrides */
    html[data-theme="catppuccin-latte"] .clock {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      letter-spacing: 0.05em;
      color: #4c4f69;
      text-shadow: none;
    }
    html[data-theme="catppuccin-latte"] h1,
    html[data-theme="catppuccin-latte"] .section-title,
    html[data-theme="catppuccin-latte"] .day-bar-label,
    html[data-theme="catppuccin-latte"] .theme-dropdown-header { font-family: 'Inter', sans-serif; }
    html[data-theme="catppuccin-latte"] .link-card {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border-width: 1px;
      border-color: #bcc0cc;
      background: #ccd0da;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    html[data-theme="catppuccin-latte"] .link-card:hover {
      background: #bcc0cc;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      transform: translateY(-1px);
    }
    html[data-theme="catppuccin-latte"] .link-card--accent1,
    html[data-theme="catppuccin-latte"] .link-card--accent2,
    html[data-theme="catppuccin-latte"] .link-card--accent3 { border-left-width: 4px; }
    html[data-theme="catppuccin-latte"] .link-icon,
    html[data-theme="catppuccin-latte"] .edit-item-btn,
    html[data-theme="catppuccin-latte"] .delete-item-btn {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
    }
    html[data-theme="catppuccin-latte"] .link-icon {
      box-shadow: 0 2px 6px rgba(30, 102, 245, 0.25);
    }
    html[data-theme="catppuccin-latte"] .day-bar-track {
      border-radius: 0;
      border-width: 1px;
      border-color: #bcc0cc;
      background: #ccd0da;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
    }
    html[data-theme="catppuccin-latte"] .day-bar-segment {
      border-radius: 0;
      background: #acb0be;
    }
    html[data-theme="catppuccin-latte"] .day-bar-segment.filled {
      background: #1e66f5 !important;
      box-shadow: 0 0 12px rgba(30, 102, 245, 0.35);
    }
    html[data-theme="catppuccin-latte"] .add-item-btn,
    html[data-theme="catppuccin-latte"] .add-category-row .add-category-btn,
    html[data-theme="catppuccin-latte"] .link-icon,
    html[data-theme="catppuccin-latte"] .modal .btn-save,
    html[data-theme="catppuccin-latte"] .modal-actions .btn-save {
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 6px rgba(30, 102, 245, 0.25);
    }
    html[data-theme="catppuccin-latte"] .edit-mode-btn {
      border-radius: 0;
      border-width: 2px;
    }
    html[data-theme="catppuccin-latte"] .edit-mode-btn.active {
      box-shadow: 0 0 16px rgba(30, 102, 245, 0.4);
    }
    html[data-theme="catppuccin-latte"] .charms-btn,
    html[data-theme="catppuccin-latte"] .charms-hamburger,
    html[data-theme="catppuccin-latte"] .edit-mode-btn,
    html[data-theme="catppuccin-latte"] .screensaver-btn {
      border-radius: 0;
      border-width: 2px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    html[data-theme="catppuccin-latte"] .theme-dropdown {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin-latte"] .theme-dropdown-option { font-family: 'Inter', sans-serif; }
    html[data-theme="catppuccin-latte"] .theme-select {
      background-color: #eff1f5;
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin-latte"] .theme-select option { background: #eff1f5; color: #4c4f69; }
    html[data-theme="catppuccin-latte"] .modal {
      border-radius: 0;
      border-width: 1px;
      border-color: #bcc0cc;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.15);
    }
    html[data-theme="catppuccin-latte"] .modal-actions .btn-cancel,
    html[data-theme="catppuccin-latte"] .modal-actions .btn-save {
      border-radius: 0;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    html[data-theme="catppuccin-latte"] .scratch-pad {
      border-radius: 0;
      border-width: 1px;
      border-color: #bcc0cc;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }
    html[data-theme="catppuccin-latte"] .scratch-pad-header {
      background: #bcc0cc;
      color: #4c4f69;
      font-family: 'Inter', sans-serif;
      border-radius: 0;
    }
    html[data-theme="catppuccin-latte"] .scratch-pad-body {
      background: #eff1f5;
      color: #4c4f69;
      caret-color: #1e66f5;
      scrollbar-color: #bcc0cc #ccd0da;
    }
    html[data-theme="catppuccin-latte"] .scratch-pad-body::-webkit-scrollbar-track { background: #ccd0da; }
    html[data-theme="catppuccin-latte"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #bcc0cc; border-radius: 0; }
    html[data-theme="catppuccin-latte"] .scratch-pad-body::placeholder { color: rgba(76, 79, 105, 0.4); }
    html[data-theme="catppuccin-latte"] #musicControlsModal input::placeholder { color: rgba(76, 79, 105, 0.4); }
    html[data-theme="catppuccin-latte"] .scratch-pad-tab {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      background: #ccd0da;
      color: #6c6f85;
    }
    html[data-theme="catppuccin-latte"] .scratch-pad-tab:hover { background: #bcc0cc; color: #4c4f69; }
    html[data-theme="catppuccin-latte"] .scratch-pad-tab.active { background: #eff1f5; color: #1e66f5; }
    html[data-theme="catppuccin-latte"] .midi-player-widget {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="catppuccin-latte"] .midi-player-widget .midi-btn {
      border-radius: 0;
    }
    html[data-theme="catppuccin-latte"] .modal input,
    html[data-theme="catppuccin-latte"] .modal select {
      border-radius: 0;
      border-color: #bcc0cc;
      background: #eff1f5;
      box-shadow: none;
    }
    html[data-theme="catppuccin-latte"] .modal input:focus,
    html[data-theme="catppuccin-latte"] .modal select:focus {
      border-color: #1e66f5;
      outline: none;
      box-shadow: 0 0 0 2px rgba(30, 102, 245, 0.25);
    }
    html[data-theme="catppuccin-latte"] .theme-dropdown-option:hover {
      background: #bcc0cc;
      color: #4c4f69;
    }

    /* Everforest component overrides */
    html[data-theme="everforest"] .clock {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      letter-spacing: 0.05em;
      color: #D3C6AA;
      text-shadow: none;
    }
    html[data-theme="everforest"] h1,
    html[data-theme="everforest"] .section-title,
    html[data-theme="everforest"] .day-bar-label,
    html[data-theme="everforest"] .theme-dropdown-header { font-family: 'Inter', sans-serif; }
    html[data-theme="everforest"] .link-card {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border-width: 1px;
      border-color: #3D484D;
      background: #343F44;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    html[data-theme="everforest"] .link-card:hover {
      background: #3D484D;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
      transform: translateY(-1px);
    }
    html[data-theme="everforest"] .link-card--accent1,
    html[data-theme="everforest"] .link-card--accent2,
    html[data-theme="everforest"] .link-card--accent3 { border-left-width: 4px; }
    html[data-theme="everforest"] .link-icon,
    html[data-theme="everforest"] .edit-item-btn,
    html[data-theme="everforest"] .delete-item-btn {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="everforest"] .link-icon {
      box-shadow: 0 2px 6px rgba(167, 192, 128, 0.3);
    }
    html[data-theme="everforest"] .day-bar-track {
      border-radius: 0;
      border-width: 1px;
      border-color: #3D484D;
      background: #343F44;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="everforest"] .day-bar-segment {
      border-radius: 0;
      background: #3D484D;
    }
    html[data-theme="everforest"] .day-bar-segment.filled {
      background: #A7C080 !important;
      box-shadow: 0 0 12px rgba(167, 192, 128, 0.4);
    }
    html[data-theme="everforest"] .add-item-btn,
    html[data-theme="everforest"] .add-category-row .add-category-btn,
    html[data-theme="everforest"] .link-icon,
    html[data-theme="everforest"] .modal .btn-save,
    html[data-theme="everforest"] .modal-actions .btn-save {
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 6px rgba(167, 192, 128, 0.3);
    }
    html[data-theme="everforest"] .edit-mode-btn { border-radius: 0; border-width: 2px; }
    html[data-theme="everforest"] .edit-mode-btn.active {
      box-shadow: 0 0 16px rgba(167, 192, 128, 0.5);
    }
    html[data-theme="everforest"] .charms-btn,
    html[data-theme="everforest"] .charms-hamburger,
    html[data-theme="everforest"] .edit-mode-btn,
    html[data-theme="everforest"] .screensaver-btn {
      border-radius: 0;
      border-width: 2px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="everforest"] .theme-dropdown { border-radius: 0; border-width: 1px; }
    html[data-theme="everforest"] .theme-dropdown-option { font-family: 'Inter', sans-serif; }
    html[data-theme="everforest"] .theme-select {
      background-color: #2D353B;
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="everforest"] .theme-select option { background: #2D353B; color: #D3C6AA; }
    html[data-theme="everforest"] .modal {
      border-radius: 0;
      border-width: 1px;
      border-color: #3D484D;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
    }
    html[data-theme="everforest"] .modal-actions .btn-cancel,
    html[data-theme="everforest"] .modal-actions .btn-save {
      border-radius: 0;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="everforest"] .scratch-pad {
      border-radius: 0;
      border-width: 1px;
      border-color: #3D484D;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="everforest"] .scratch-pad-header {
      background: #3D484D;
      color: #D3C6AA;
      font-family: 'Inter', sans-serif;
      border-radius: 0;
    }
    html[data-theme="everforest"] .scratch-pad-body {
      background: #232A2E;
      color: #D3C6AA;
      caret-color: #A7C080;
      scrollbar-color: #3D484D #343F44;
    }
    html[data-theme="everforest"] .scratch-pad-body::-webkit-scrollbar-track { background: #343F44; }
    html[data-theme="everforest"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #3D484D; border-radius: 0; }
    html[data-theme="everforest"] .scratch-pad-body::placeholder { color: rgba(211, 198, 170, 0.4); }
    html[data-theme="everforest"] #musicControlsModal input::placeholder { color: rgba(211, 198, 170, 0.4); }
    html[data-theme="everforest"] .scratch-pad-tab {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      background: #343F44;
      color: #859289;
    }
    html[data-theme="everforest"] .scratch-pad-tab:hover { background: #3D484D; color: #D3C6AA; }
    html[data-theme="everforest"] .scratch-pad-tab.active { background: #2D353B; color: #A7C080; }
    html[data-theme="everforest"] .midi-player-widget {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="everforest"] .midi-player-widget .midi-btn { border-radius: 0; }
    html[data-theme="everforest"] .modal input,
    html[data-theme="everforest"] .modal select {
      border-radius: 0;
      border-color: #3D484D;
      background: #343F44;
      box-shadow: none;
    }
    html[data-theme="everforest"] .modal input:focus,
    html[data-theme="everforest"] .modal select:focus {
      border-color: #A7C080;
      outline: none;
      box-shadow: 0 0 0 2px rgba(167, 192, 128, 0.3);
    }
    html[data-theme="everforest"] .theme-dropdown-option:hover {
      background: #3D484D;
      color: #D3C6AA;
    }

    /* Tokyo Night component overrides */
    html[data-theme="tokyo-night"] .clock {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      letter-spacing: 0.05em;
      color: #c0caf5;
      text-shadow: none;
    }
    html[data-theme="tokyo-night"] h1,
    html[data-theme="tokyo-night"] .section-title,
    html[data-theme="tokyo-night"] .day-bar-label,
    html[data-theme="tokyo-night"] .theme-dropdown-header { font-family: 'Inter', sans-serif; }
    html[data-theme="tokyo-night"] .link-card {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border-width: 1px;
      border-color: #414868;
      background: #24283b;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    html[data-theme="tokyo-night"] .link-card:hover {
      background: #414868;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
      transform: translateY(-1px);
    }
    html[data-theme="tokyo-night"] .link-card--accent1,
    html[data-theme="tokyo-night"] .link-card--accent2,
    html[data-theme="tokyo-night"] .link-card--accent3 { border-left-width: 4px; }
    html[data-theme="tokyo-night"] .link-icon,
    html[data-theme="tokyo-night"] .edit-item-btn,
    html[data-theme="tokyo-night"] .delete-item-btn {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="tokyo-night"] .link-icon {
      box-shadow: 0 2px 6px rgba(122, 162, 247, 0.3);
    }
    html[data-theme="tokyo-night"] .day-bar-track {
      border-radius: 0;
      border-width: 1px;
      border-color: #414868;
      background: #24283b;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    html[data-theme="tokyo-night"] .day-bar-segment {
      border-radius: 0;
      background: #414868;
    }
    html[data-theme="tokyo-night"] .day-bar-segment.filled {
      background: #7aa2f7 !important;
      box-shadow: 0 0 12px rgba(122, 162, 247, 0.4);
    }
    html[data-theme="tokyo-night"] .add-item-btn,
    html[data-theme="tokyo-night"] .add-category-row .add-category-btn,
    html[data-theme="tokyo-night"] .link-icon,
    html[data-theme="tokyo-night"] .modal .btn-save,
    html[data-theme="tokyo-night"] .modal-actions .btn-save {
      border-radius: 0;
      border: none;
      box-shadow: 0 2px 6px rgba(122, 162, 247, 0.3);
    }
    html[data-theme="tokyo-night"] .edit-mode-btn { border-radius: 0; border-width: 2px; }
    html[data-theme="tokyo-night"] .edit-mode-btn.active {
      box-shadow: 0 0 16px rgba(122, 162, 247, 0.5);
    }
    html[data-theme="tokyo-night"] .charms-btn,
    html[data-theme="tokyo-night"] .charms-hamburger,
    html[data-theme="tokyo-night"] .edit-mode-btn,
    html[data-theme="tokyo-night"] .screensaver-btn {
      border-radius: 0;
      border-width: 2px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    html[data-theme="tokyo-night"] .theme-dropdown { border-radius: 0; border-width: 1px; }
    html[data-theme="tokyo-night"] .theme-dropdown-option { font-family: 'Inter', sans-serif; }
    html[data-theme="tokyo-night"] .theme-select {
      background-color: #1a1b26;
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="tokyo-night"] .theme-select option { background: #1a1b26; color: #c0caf5; }
    html[data-theme="tokyo-night"] .modal {
      border-radius: 0;
      border-width: 1px;
      border-color: #414868;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.5);
    }
    html[data-theme="tokyo-night"] .modal-actions .btn-cancel,
    html[data-theme="tokyo-night"] .modal-actions .btn-save {
      border-radius: 0;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }
    html[data-theme="tokyo-night"] .scratch-pad {
      border-radius: 0;
      border-width: 1px;
      border-color: #414868;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    }
    html[data-theme="tokyo-night"] .scratch-pad-header {
      background: #414868;
      color: #c0caf5;
      font-family: 'Inter', sans-serif;
      border-radius: 0;
    }
    html[data-theme="tokyo-night"] .scratch-pad-body {
      background: #16161e;
      color: #c0caf5;
      caret-color: #7aa2f7;
      scrollbar-color: #414868 #24283b;
    }
    html[data-theme="tokyo-night"] .scratch-pad-body::-webkit-scrollbar-track { background: #24283b; }
    html[data-theme="tokyo-night"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #414868; border-radius: 0; }
    html[data-theme="tokyo-night"] .scratch-pad-body::placeholder { color: rgba(192, 202, 245, 0.4); }
    html[data-theme="tokyo-night"] #musicControlsModal input::placeholder { color: rgba(192, 202, 245, 0.4); }
    html[data-theme="tokyo-night"] .scratch-pad-tab {
      font-family: 'Inter', sans-serif;
      border-radius: 0;
      background: #24283b;
      color: #565f89;
    }
    html[data-theme="tokyo-night"] .scratch-pad-tab:hover { background: #414868; color: #c0caf5; }
    html[data-theme="tokyo-night"] .scratch-pad-tab.active { background: #1a1b26; color: #7aa2f7; }
    html[data-theme="tokyo-night"] .midi-player-widget {
      border-radius: 0;
      border-width: 1px;
    }
    html[data-theme="tokyo-night"] .midi-player-widget .midi-btn { border-radius: 0; }
    html[data-theme="tokyo-night"] .modal input,
    html[data-theme="tokyo-night"] .modal select {
      border-radius: 0;
      border-color: #414868;
      background: #24283b;
      box-shadow: none;
    }
    html[data-theme="tokyo-night"] .modal input:focus,
    html[data-theme="tokyo-night"] .modal select:focus {
      border-color: #7aa2f7;
      outline: none;
      box-shadow: 0 0 0 2px rgba(122, 162, 247, 0.3);
    }
    html[data-theme="tokyo-night"] .theme-dropdown-option:hover {
      background: #414868;
      color: #c0caf5;
    }

    /* Megadrive/16-bit theme scratch-pad – retro chunky borders */
    html[data-theme="megadrive"] .scratch-pad {
      border-radius: 0;
      border: 3px solid var(--card-border);
      box-shadow: 2px 2px 0 var(--bevel-dark), inset 2px 2px 0 var(--bevel-light);
    }
    html[data-theme="megadrive"] .scratch-pad-header {
      border-radius: 0;
      border-bottom: 3px solid var(--card-border);
    }
    html[data-theme="megadrive"] .scratch-pad-tab {
      border-radius: 0;
      border-width: 2px;
    }
    html[data-theme="megadrive"] .scratch-pad-body {
      border-radius: 0;
      box-shadow: none;
    }
    html[data-theme="megadrive"] .scratch-pad-body::-webkit-scrollbar { border-radius: 0; }
    html[data-theme="megadrive"] .scratch-pad-body::-webkit-scrollbar-thumb { border-radius: 0; border: 2px solid var(--card-border); }
    html[data-theme="megadrive"] .scratch-pad-maximize-btn { border-radius: 0; }
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
    html[data-theme="ps5"] .link-card--accent1,
    html[data-theme="ps5"] .link-card--accent2,
    html[data-theme="ps5"] .link-card--accent3 { border-left-width: 3px; }
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
    html[data-theme="macintosh"] .link-card--accent1,
    html[data-theme="macintosh"] .link-card--accent2,
    html[data-theme="macintosh"] .link-card--accent3 { border-left-width: 4px; }
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
      color: #ffffff;
      background: transparent;
      border: 1px solid rgba(255,255,255,0.5);
    }
    html[data-theme="msdos"] .scratch-pad-stop-btn:hover:not(:disabled) {
      background: rgba(255,255,255,0.2);
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

    /* Star Trek TNG / LCARS theme overrides */
    html[data-theme="lcars"] .clock {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      margin-left: 0;
      margin-right: 0;
      padding: 0.75rem 1.5rem 0.75rem 1rem;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 0 20px 20px 0;
      color: #ff9900;
      font-size: 3.2rem;
      font-weight: 700;
      letter-spacing: 0.25em;
      text-shadow: none;
      border: none;
      box-shadow: 0 0 0 2px rgba(255, 136, 0, 0.3);
    }
    html[data-theme="lcars"] .clock::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 14px;
      background: #ff8800;
      border-radius: 0 8px 8px 0;
    }
    html[data-theme="lcars"] .clock {
      padding-left: 2rem;
    }
    html[data-theme="lcars"] .link-card {
      border-color: rgba(255, 136, 0, 0.5);
      box-shadow: inset 0 0 15px rgba(255, 136, 0, 0.06), 0 0 10px rgba(255, 136, 0, 0.08);
    }
    html[data-theme="lcars"] .link-card:hover {
      background: rgba(255, 136, 0, 0.12);
      box-shadow: inset 0 0 15px rgba(255, 136, 0, 0.1), 0 0 15px rgba(255, 136, 0, 0.18);
    }
    html[data-theme="lcars"] .link-card--accent1,
    html[data-theme="lcars"] .link-card--accent2,
    html[data-theme="lcars"] .link-card--accent3 { box-shadow: 0 0 8px rgba(255, 170, 51, 0.25); }
    html[data-theme="lcars"] .day-bar-track {
      border-color: #ff8800;
      box-shadow: inset 0 0 10px rgba(255, 136, 0, 0.08), 0 0 6px rgba(255, 136, 0, 0.15);
    }
    html[data-theme="lcars"] .day-bar-segment.filled {
      background: #ff8800 !important;
      box-shadow: 0 0 8px rgba(255, 136, 0, 0.5);
    }
    html[data-theme="lcars"] .day-bar-label { color: #cc7700; }
    html[data-theme="lcars"] .section-title { color: #ff9900; }
    html[data-theme="lcars"] .add-item-btn,
    html[data-theme="lcars"] .add-category-row .add-category-btn,
    html[data-theme="lcars"] .link-icon,
    html[data-theme="lcars"] .modal .btn-save,
    html[data-theme="lcars"] .modal-actions .btn-save {
      border-color: #ff8800;
      box-shadow: 0 0 8px rgba(255, 136, 0, 0.35);
      color: #0a0a12;
    }
    html[data-theme="lcars"] .add-item-btn:hover,
    html[data-theme="lcars"] .add-category-row .add-category-btn:hover,
    html[data-theme="lcars"] .link-icon:hover,
    html[data-theme="lcars"] .modal .btn-save:hover,
    html[data-theme="lcars"] .modal-actions .btn-save:hover {
      color: #0a0a12;
      box-shadow: 0 0 12px rgba(255, 136, 0, 0.5);
    }
    html[data-theme="lcars"] .edit-mode-btn.active {
      box-shadow: 0 0 10px rgba(255, 136, 0, 0.5);
      color: #0a0a12;
    }
    html[data-theme="lcars"] .edit-blocks-btn { border-color: #ff8800; color: #cc7700; }
    html[data-theme="lcars"] .edit-blocks-btn:hover { background: rgba(255, 136, 0, 0.2); color: #ff9900; }
    html[data-theme="lcars"] .theme-select {
      background-color: #0a0a12;
      box-shadow: 0 0 8px rgba(255, 136, 0, 0.2);
    }
    html[data-theme="lcars"] .theme-select option { background: #0a0a12; color: #ff8800; }
    html[data-theme="lcars"] .theme-select:hover,
    html[data-theme="lcars"] .theme-select:focus { border-color: #ffaa33; box-shadow: 0 0 8px rgba(255, 136, 0, 0.3); }
    html[data-theme="lcars"] .charms-btn,
    html[data-theme="lcars"] .charms-hamburger,
    html[data-theme="lcars"] .edit-mode-btn,
    html[data-theme="lcars"] .screensaver-btn { border-color: #ff8800; color: #cc7700; }
    html[data-theme="lcars"] .charms-btn:hover,
    html[data-theme="lcars"] .charms-hamburger:hover,
    html[data-theme="lcars"] .edit-mode-btn:hover,
    html[data-theme="lcars"] .screensaver-btn:hover { background: rgba(255, 136, 0, 0.2); color: #ff9900; }
    html[data-theme="lcars"] .theme-charm-btn { border-color: #ff8800; color: #ff8800; }
    html[data-theme="lcars"] .theme-charm-btn:hover { background: #ff8800; color: #0a0a12; }
    html[data-theme="lcars"] .theme-dropdown-option:hover { background: rgba(255, 136, 0, 0.2); color: #ff9900; }
    html[data-theme="lcars"] .midi-player-widget { border-color: #ff8800; }
    html[data-theme="lcars"] .midi-player-widget .midi-btn { border-color: #ff8800; color: #ff9900; }
    html[data-theme="lcars"] .midi-player-widget .midi-btn:hover { background: rgba(255, 136, 0, 0.2); color: #ffaa33; }
    html[data-theme="lcars"] .midi-player-widget .midi-track-name { color: #cc7700; }
    html[data-theme="lcars"] .midi-player-widget .midi-mode-btn.active {
      background: #ff8800;
      color: #0a0a12;
      border-color: #ff8800;
    }
    html[data-theme="lcars"] .midi-player-widget .midi-mode-btn.active:hover {
      background: #ffaa33;
      border-color: #ffaa33;
      color: #0a0a12;
    }
    html[data-theme="lcars"] .midi-progress-bar { border-color: #ff8800; }
    html[data-theme="lcars"] .midi-progress-bar:focus { border-color: #ffaa33; }
    html[data-theme="lcars"] .scratch-pad {
      border-color: #ff8800;
      box-shadow: inset 0 0 15px rgba(255, 136, 0, 0.08), 0 0 10px rgba(255, 136, 0, 0.12);
    }
    html[data-theme="lcars"] .scratch-pad-header { background: #ff8800; color: #0a0a12; }
    html[data-theme="lcars"] .scratch-pad-body {
      background: rgba(0, 0, 0, 0.6);
      color: #ff9900;
      caret-color: #ff9900;
    }
    html[data-theme="lcars"] .scratch-pad-body { scrollbar-color: #ff8800 #050508; }
    html[data-theme="lcars"] .scratch-pad-body::-webkit-scrollbar-track { background: #050508; }
    html[data-theme="lcars"] .scratch-pad-body::-webkit-scrollbar-thumb { background: #ff8800; }
    html[data-theme="lcars"] .scratch-pad-body::-webkit-scrollbar-thumb:hover { background: #ffaa33; }
    html[data-theme="lcars"] .scratch-pad-body::placeholder { color: rgba(255, 136, 0, 0.5); }
    html[data-theme="lcars"] #musicControlsModal input::placeholder { color: rgba(255, 136, 0, 0.5); }
    html[data-theme="lcars"] .scratch-pad-title::before { content: 'LCARS / '; opacity: 0.8; }
    html[data-theme="lcars"] .scratch-pad-tab { background: rgba(255, 136, 0, 0.15); color: #0a0a12; }
    html[data-theme="lcars"] .scratch-pad-tab:hover { background: rgba(255, 136, 0, 0.3); color: #0a0a12; }
    html[data-theme="lcars"] .scratch-pad-tab.active { background: #0a0a12; color: #ff8800; }
    html[data-theme="lcars"] .scratch-pad-run-js-btn,
    html[data-theme="lcars"] .scratch-pad-maximize-btn {
      background: #0a0a12;
      color: #ff8800;
      border-color: #ff8800;
    }
    html[data-theme="lcars"] .scratch-pad-run-js-btn:hover,
    html[data-theme="lcars"] .scratch-pad-maximize-btn:hover {
      background: #ff8800;
      color: #0a0a12;
    }
    html[data-theme="lcars"] .scratch-pad-stop-btn {
      background: #0a0a12;
      color: #ff8800;
      border-color: #ff8800;
    }
    html[data-theme="lcars"] .scratch-pad-stop-btn:hover:not(:disabled) {
      background: #ff8800;
      color: #0a0a12;
    }
    html[data-theme="lcars"] .modal {
      border-color: #ff8800;
      box-shadow: 0 0 30px rgba(255, 136, 0, 0.15);
    }
    html[data-theme="lcars"] .modal h3,
    html[data-theme="lcars"] .modal label { color: #ff9900; }
    html[data-theme="lcars"] .modal input,
    html[data-theme="lcars"] .modal select {
      background: #0a0a12;
      border: 2px solid #ff8800;
      color: #ff9900;
    }
    html[data-theme="lcars"] .modal input:focus,
    html[data-theme="lcars"] .modal select:focus {
      border-color: #ffaa33;
      box-shadow: 0 0 8px rgba(255, 136, 0, 0.3);
    }
    html[data-theme="lcars"] .modal-actions .btn-cancel {
      background: #12121a;
      color: #ff9900;
      border: 2px solid #ff8800;
    }
    html[data-theme="lcars"] .modal-actions .btn-cancel:hover { background: rgba(255, 136, 0, 0.15); }

    /* Retro themes: modal overlays that fit the era */
    /* 16-bit style: low-res dithered grid (black pixel / transparent alternating – see through where not black) */
    html[data-theme="megadrive"] .modal-overlay,
    html[data-theme="sms"] .modal-overlay {
      background-image: repeating-conic-gradient(
        from 0deg at 50% 50%,
        #000 0deg 90deg,
        transparent 90deg 180deg,
        #000 180deg 270deg,
        transparent 270deg 360deg
      );
      background-size: 8px 8px;
    }
    /* Simpler systems: solid overlay (completely hides content behind modal) */
    html[data-theme="gb"] .modal-overlay,
    html[data-theme="macintosh"] .modal-overlay,
    html[data-theme="msdos"] .modal-overlay {
      background: var(--bg);
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
    html[data-theme="lcars"] .screensaver-clock {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem 2rem 1rem 2.5rem;
      background: rgba(0, 0, 0, 0.7);
      border-radius: 0 24px 24px 0;
      color: #ff9900;
      font-size: 4rem;
      font-weight: 700;
      letter-spacing: 0.25em;
      text-shadow: none;
      box-shadow: 0 0 0 2px rgba(255, 136, 0, 0.4);
    }
    html[data-theme="lcars"] .screensaver-clock::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 18px;
      background: #ff8800;
      border-radius: 0 10px 10px 0;
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
    .screensaver-day-bars .day-bar-segment.filled {
      background: var(--button-bg);
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
    html[data-theme="lcars"] .screensaver-midi-track { color: rgba(255, 136, 0, 0.7); }
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
    html[data-theme="lcars"] .screensaver-day-bars .day-bar-track {
      border-color: #ff8800;
      box-shadow: inset 0 0 10px rgba(255, 136, 0, 0.08);
    }
    html[data-theme="lcars"] .screensaver-day-bars .day-bar-segment.filled {
      background: #ff8800 !important;
      box-shadow: 0 0 8px rgba(255, 136, 0, 0.5);
    }

    /* Event notification modal – themed */
    .event-notification-modal .modal {
      border-width: 3px;
      border-color: var(--card-border);
      box-shadow: inset 2px 2px 0 var(--bevel-light), 6px 6px 0 var(--bevel-dark);
    }
    .event-notification-title {
      color: var(--content);
      margin: 0 0 0.25rem 0;
      font-size: 1.25rem;
    }
    .event-notification-time {
      color: var(--content-muted);
      margin: 0 0 1rem 0;
      font-size: 0.9rem;
    }
    .event-notification-progress-wrap {
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
      margin-bottom: 0.5rem;
    }
    .event-notification-progress-bar {
      height: 8px;
      background: var(--bevel-dark);
      border: 2px solid var(--card-border);
      overflow: hidden;
      border-radius: 4px;
    }
    .event-notification-progress-fill {
      height: 100%;
      background: var(--button-bg);
      width: 100%;
      transition: none;
    }
    .event-notification-progress-fill.countdown-active {
      animation: event-countdown-shrink 30s linear forwards;
    }
    @keyframes event-countdown-shrink {
      from { width: 100%; }
      to { width: 0%; }
    }
    .event-notification-countdown {
      font-size: 0.75rem;
      color: var(--content-muted);
      font-variant-numeric: tabular-nums;
      min-width: 8.5em;
      display: inline-block;
    }
    html[data-theme="gb"] .help-modal-content .help-shortcuts {
      color: #9bbc0f;
    }
    html[data-theme="gb"] .help-modal-content .help-shortcuts code {
      color: #9bbc0f;
    }
    html[data-theme="macintosh"] .help-modal-content .help-shortcuts {
      color: #ffffff;
    }
    html[data-theme="macintosh"] .help-modal-content .help-shortcuts code {
      color: #ffffff;
    }
    html[data-theme="gb"] .event-notification-progress-bar {
      background: #8bac0f;
      border-color: #306230;
    }
    html[data-theme="gb"] .event-notification-progress-fill {
      background: #0f380f;
    }
    html[data-theme="macintosh"] .event-notification-progress-bar {
      background: #ffffff;
      border-color: #000000;
    }
    html[data-theme="macintosh"] .event-notification-progress-fill {
      background: #000000;
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

    /* Header indicators – offline & stop music on far right of title */
    .sidebar-header-indicators {
      display: flex;
      align-items: center;
      gap: 0.35rem;
      flex-shrink: 0;
    }
    .offline-indicator,
    .stop-music-indicator {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.25rem 0.6rem;
      font-size: 0.65rem;
      font-family: 'Silkscreen', 'JetBrains Mono', monospace;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--content-muted);
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      box-shadow: inset 1px 1px 0 var(--bevel-light), 2px 2px 0 var(--bevel-dark);
      border-radius: 4px;
      transition: opacity 0.3s ease;
      line-height: 1.35;
      min-height: 1.5rem;
      box-sizing: border-box;
    }
    .offline-indicator {
      display: none;
      opacity: 0;
    }
    .offline-indicator.visible {
      display: inline-flex;
      opacity: 1;
      background: var(--card-border);
      color: var(--button-fg, var(--bg));
    }
    .stop-music-indicator {
      display: none;
      cursor: pointer;
    }
    .stop-music-indicator.visible {
      display: inline-flex;
    }
    .stop-music-indicator:hover {
      background: var(--card-border);
      color: var(--button-fg, var(--bg));
    }
    body.screensaver-active .offline-indicator,
    body.screensaver-active .stop-music-indicator {
      opacity: 0 !important;
      pointer-events: none;
    }
    @keyframes offline-pulsate {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    .offline-indicator.visible {
      animation: offline-pulsate 2s ease-in-out infinite;
    }
    html[data-theme="megadrive"] .offline-indicator.visible,
    html[data-theme="tron"] .offline-indicator.visible,
    html[data-theme="tron-ares"] .offline-indicator.visible,
    html[data-theme="matrix"] .offline-indicator.visible,
    html[data-theme="sms"] .offline-indicator.visible,
    html[data-theme="gb"] .offline-indicator.visible,
    html[data-theme="macintosh"] .offline-indicator.visible,
    html[data-theme="msdos"] .offline-indicator.visible,
    html[data-theme="lcars"] .offline-indicator.visible {
      animation: none;
    }

    /* Game menu and overlays */
    .game-menu-modal .game-menu-buttons {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .game-menu-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.25rem;
      padding: 1.25rem 1.5rem;
      min-width: 140px;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      color: var(--content);
      font-family: inherit;
      font-size: 0.9rem;
      cursor: pointer;
    }
    .game-menu-btn:hover {
      background: var(--card-border);
      color: var(--button-fg, var(--bg));
    }
    .game-menu-btn-icon { font-size: 1.5rem; }
    .game-menu-btn-desc { font-size: 0.7rem; opacity: 0.8; }
    .game-overlay {
      /* Inherit theme backdrop from .modal-overlay (16-bit, gb, etc.) */
    }
    .game-overlay-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.5rem;
    }
    .game-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      max-width: 320px;
    }
    .game-stats {
      display: flex;
      gap: 1rem;
      font-size: 0.85rem;
    }
    .game-back-btn {
      padding: 0.35rem 0.75rem;
      background: var(--card-bg);
      border: 2px solid var(--card-border);
      color: var(--content);
      font-family: inherit;
      font-size: 0.8rem;
      cursor: pointer;
    }
    .game-back-btn:hover {
      background: var(--card-border);
    }
    .tetris-wrap, .snake-wrap {
      background: var(--game-board-bg);
      border: 4px solid var(--game-border);
    }
    #tetrisCanvas {
      display: block;
      image-rendering: pixelated;
      image-rendering: crisp-edges;
    }
    #snakeCanvas {
      display: block;
      image-rendering: pixelated;
      image-rendering: crisp-edges;
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
        <div class="sidebar-header-indicators">
          <span class="stop-music-indicator" id="stopMusicBtn" role="button" tabindex="0" aria-label="Stop music">Stop ♪</span>
          <span class="offline-indicator" id="offlineIndicator" aria-live="polite" data-tooltip="Server unavailable – showing cached copy">Offline</span>
        </div>
      </div>
      <div id="categoriesContainer"></div>
      <div class="scratch-pad" id="scratchPad">
        <div class="scratch-pad-header">
          <span class="scratch-pad-tabs">
            <button class="scratch-pad-tab active" type="button" id="scratchPadTextTab" data-tab="text">Text</button>
            <button class="scratch-pad-tab" type="button" id="scratchPadBasicTab" data-tab="basic">Basic</button>
          </span>
          <span class="scratch-pad-header-actions">
            <button class="scratch-pad-stop-btn" type="button" id="scratchPadStopBtn" data-tooltip="Stop execution" data-tooltip-pos="right" style="display:none">STOP</button>
            <button class="scratch-pad-maximize-btn" type="button" id="scratchPadMaximizeBtn" data-tooltip="Full screen" data-tooltip-pos="right">⛶</button>
          </span>
        </div>
        <div class="scratch-pad-body-container">
          <div class="scratch-pad-body scratch-pad-text-editor" id="scratchPadText" contenteditable="true" data-placeholder="Text notes..." role="textbox"></div>
          <textarea class="scratch-pad-body" id="scratchPadBasic" placeholder="10 PRINT &quot;Hello&quot; ... RUN" rows="4" style="display:none"></textarea>
        </div>
      </div>
    </aside>
    <nav class="charms-menu" aria-label="Charms">
      <div class="charms-tray">
        <button class="charms-btn" id="fullscreenCharmBtn" type="button" data-tooltip="Fullscreen (Alt+Shift+F)" data-tooltip-pos="right" aria-label="Fullscreen">⛶</button>
        <button class="charms-btn music-charm-in-tray" id="musicCharmBtnTray" type="button" data-tooltip="Music (Alt+Shift+M)" data-tooltip-pos="right" aria-label="Music controls">♪</button>
        <button class="screensaver-btn" id="screensaverBtn" type="button" data-tooltip="Screensaver (Alt+Shift+S)" data-tooltip-pos="right">◐</button>
        <button class="charms-btn" id="helpCharmBtn" type="button" data-tooltip="Help (Alt+Shift+H)" data-tooltip-pos="right" aria-label="Help">?</button>
        <button class="edit-mode-btn" id="editModeBtn" type="button" data-tooltip="Edit (Alt+Shift+D)" data-tooltip-pos="right">✎</button>
        <div class="theme-switcher-charms">
          <button class="charms-btn theme-charm-btn" id="themeCharmBtn" type="button" data-tooltip="Theme (Alt+Shift+T)" data-tooltip-pos="right" aria-label="Theme">&#9881;</button>
        <div class="theme-dropdown" id="themeDropdown">
          <div class="theme-dropdown-header">Shift + Alt + T to cycle</div>
          <div class="theme-dropdown-options">
            <button class="theme-dropdown-option" data-theme="megadrive">16-bit</button>
            <button class="theme-dropdown-option" data-theme="tron">Tron</button>
            <button class="theme-dropdown-option" data-theme="tron-ares">Ares</button>
            <button class="theme-dropdown-option" data-theme="matrix">Matrix</button>
            <button class="theme-dropdown-option" data-theme="catppuccin">Catppuccin</button>
            <button class="theme-dropdown-option" data-theme="catppuccin-latte">Catppuccin Latte</button>
            <button class="theme-dropdown-option" data-theme="everforest">Everforest</button>
            <button class="theme-dropdown-option" data-theme="tokyo-night">Tokyo Night</button>
            <button class="theme-dropdown-option" data-theme="sms">SMS</button>
            <button class="theme-dropdown-option" data-theme="gb">GB</button>
            <button class="theme-dropdown-option" data-theme="ps5">PS5</button>
            <button class="theme-dropdown-option" data-theme="lcars">TNG</button>
            <button class="theme-dropdown-option" data-theme="macintosh">Macintosh</button>
            <button class="theme-dropdown-option" data-theme="msdos">MS-DOS</button>
          </div>
        </div>
        <select class="theme-select" id="themeSelect" aria-label="Select theme" style="position:absolute;opacity:0;pointer-events:none;width:0;height:0">
          <option value="megadrive">16-bit</option>
          <option value="tron">Tron</option>
          <option value="tron-ares">Ares</option>
          <option value="matrix">Matrix</option>
          <option value="catppuccin">Catppuccin</option>
          <option value="catppuccin-latte">Catppuccin Latte</option>
          <option value="everforest">Everforest</option>
          <option value="tokyo-night">Tokyo Night</option>
          <option value="sms">SMS</option>
          <option value="gb">GB</option>
          <option value="ps5">PS5</option>
          <option value="lcars">TNG</option>
          <option value="macintosh">Macintosh</option>
          <option value="msdos">MS-DOS</option>
        </select>
        </div>
      </div>
      <button class="charms-hamburger" id="charmsHamburgerBtn" type="button" data-tooltip="Charms (Alt+Shift+C)" data-tooltip-pos="right" aria-label="Open charms" aria-expanded="false">☰</button>
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
        <button class="midi-btn" id="midiPrevBtn" type="button" data-tooltip="Previous" aria-label="Previous">⏮</button>
        <button class="midi-btn" id="midiPlayBtn" type="button" data-tooltip="Play" aria-label="Play">▶</button>
        <button class="midi-btn" id="midiPauseBtn" type="button" data-tooltip="Pause" aria-label="Pause" style="display:none">⏸</button>
        <button class="midi-btn" id="midiNextBtn" type="button" data-tooltip="Next" aria-label="Next">⏭</button>
        <span class="midi-track-name" id="midiTrackName">—</span>
        <div class="midi-mode-group">
          <span class="midi-mode-sep" aria-hidden="true">|</span>
          <button class="midi-btn midi-mode-btn" id="midiShuffleBtn" type="button" data-tooltip="Shuffle" aria-label="Shuffle" aria-pressed="false"><span class="material-icons">shuffle</span></button>
          <button class="midi-btn midi-mode-btn" id="midiRepeatOneBtn" type="button" data-tooltip="Repeat current song" aria-label="Repeat one" aria-pressed="false"><span class="material-icons">repeat_one</span></button>
          <button class="midi-btn midi-mode-btn" id="midiRepeatAllBtn" type="button" data-tooltip="Repeat playlist" aria-label="Repeat all" aria-pressed="false"><span class="material-icons">repeat</span></button>
        </div>
      </div>
      <div class="midi-progress-wrap" style="margin-top:0.5rem">
        <div class="midi-progress-bar" id="midiProgressBar" role="slider" aria-label="Track position" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0" data-tooltip="Click to seek">
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

  <div class="modal-overlay" id="helpModal">
    <div class="modal">
      <h3>Help</h3>
      <div class="help-modal-content">
        <p>Welcome! This is your developer start page. Here&rsquo;s a quick overview:</p>
        <ul>
          <li><strong>Categories & links</strong> — Click cards to visit; use Edit mode to add, edit, reorder, or delete.</li>
          <li><strong>Scratchpad</strong> — Text notes with checkboxes (<code>[ ]</code> or <code>-</code> for bullets); Basic tab runs a simple BASIC interpreter.</li>
          <li><strong>Daily events</strong> — Edit mode shows &ldquo;Edit blocks&rdquo; to customize your day timeline.</li>
          <li><strong>Charms</strong> — Fullscreen, music, screensaver, theme switcher, and this help.</li>
          <li><strong>Offline mode</strong> — When the server is unavailable, the page loads from cache and shows an &ldquo;Offline&rdquo; indicator. Links and data from your last visit remain usable.</li>
        </ul>
        <p style="margin-top:0.75rem;margin-bottom:0.5rem">Charms shortcuts:</p>
        <div class="help-shortcuts"><code>Alt + Shift + C</code> — Charms (focus & expand)</div>
        <div class="help-shortcuts"><code>Alt + Shift + F</code> — Fullscreen</div>
        <div class="help-shortcuts"><code>Alt + Shift + M</code> — Music</div>
        <div class="help-shortcuts"><code>Alt + Shift + S</code> — Screensaver</div>
        <div class="help-shortcuts"><code>Alt + Shift + H</code> — Help</div>
        <div class="help-shortcuts"><code>Alt + Shift + D</code> — Edit mode</div>
        <div class="help-shortcuts"><code>Alt + Shift + T</code> — Cycle theme</div>
        <p style="margin-top:0.75rem;margin-bottom:0.5rem">Other shortcuts:</p>
        <div class="help-shortcuts"><code>Alt + Shift + E</code> — Test event modal</div>
        <div class="help-shortcuts"><code>Alt + Shift + O</code> — Simulate offline (test the indicator)</div>
        <div class="help-shortcuts"><code>Alt + Shift + G</code> — Games (Tetris, Snake)</div>
        <div class="help-shortcuts"><code>Escape</code> — Close any open modal</div>
      </div>
      <div class="modal-actions" style="margin-top: 1rem;">
        <button class="btn-cancel" type="button" id="helpModalCloseBtn">Close</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay event-notification-modal" id="eventNotificationModal">
    <div class="modal event-notification-modal-inner">
      <h3 class="event-notification-title" id="eventNotificationTitle">Event</h3>
      <p class="event-notification-time" id="eventNotificationTime"></p>
      <div class="event-notification-progress-wrap">
        <div class="event-notification-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="30" aria-valuenow="30" aria-label="Auto-close countdown">
          <div class="event-notification-progress-fill" id="eventNotificationProgressFill"></div>
        </div>
        <span class="event-notification-countdown" id="eventNotificationCountdown">Closing in 30s</span>
      </div>
      <div class="modal-actions" style="margin-top: 1rem;">
        <button class="btn-save" type="button" id="eventNotificationDismissBtn">Dismiss</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="gameMenuModal">
    <div class="modal game-menu-modal">
      <h3>Games</h3>
      <div class="game-menu-buttons">
        <button class="game-menu-btn" type="button" id="gameMenuTetrisBtn">
          <span class="game-menu-btn-icon">▦</span>
          <span>Tetris</span>
          <span class="game-menu-btn-desc">Game Boy style</span>
        </button>
        <button class="game-menu-btn" type="button" id="gameMenuSnakeBtn">
          <span class="game-menu-btn-icon">◆</span>
          <span>Snake</span>
          <span class="game-menu-btn-desc">Nokia style</span>
        </button>
      </div>
      <div class="modal-actions" style="margin-top:1rem">
        <button class="btn-cancel" type="button" id="gameMenuCloseBtn">Close</button>
      </div>
    </div>
  </div>

  <div class="modal-overlay game-overlay" id="tetrisGameOverlay">
    <div class="game-overlay-inner">
      <div class="game-header">
        <div class="game-stats">
          <span>Score: <strong id="tetrisScore">0</strong></span>
          <span>Level: <strong id="tetrisLevel">0</strong></span>
          <span>Lines: <strong id="tetrisLines">0</strong></span>
        </div>
        <button class="game-back-btn" type="button" id="tetrisBackBtn">← Back</button>
      </div>
      <div class="tetris-wrap">
        <canvas id="tetrisCanvas" width="200" height="360"></canvas>
      </div>
    </div>
  </div>

  <div class="modal-overlay game-overlay" id="snakeGameOverlay">
    <div class="game-overlay-inner">
      <div class="game-header">
        <div class="game-stats">
          <span>Score: <strong id="snakeScore">0</strong></span>
        </div>
        <button class="game-back-btn" type="button" id="snakeBackBtn">← Back</button>
      </div>
      <div class="snake-wrap">
        <canvas id="snakeCanvas" width="300" height="300"></canvas>
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
        <label>URL</label>
        <input type="url" id="modalItemUrl" placeholder="https://..." required>
        <label id="colorSelectLabel">Color</label>
        <div class="color-select-wrap">
          <select id="modalItemColor" aria-hidden="true" tabindex="-1" style="position:absolute;opacity:0;pointer-events:none;width:0;height:0">
            <option value="">None</option>
            <option value="accent1">Accent 1</option>
            <option value="accent2">Accent 2</option>
            <option value="accent3">Accent 3</option>
          </select>
          <button type="button" class="color-select-trigger" id="colorSelectTrigger" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="colorSelectLabel">
            <span class="color-swatch color-swatch--none" aria-hidden="true"></span>
            <span class="color-select-label">None</span>
            <span class="color-select-chevron" aria-hidden="true">▼</span>
          </button>
          <div class="color-select-dropdown" id="colorSelectDropdown" role="listbox" aria-label="Link color" hidden>
            <div class="color-select-option" role="option" data-value="" tabindex="0">
              <span class="color-swatch color-swatch--none" aria-hidden="true"></span>
              <span>None</span>
            </div>
            <div class="color-select-option" role="option" data-value="accent1" tabindex="0">
              <span class="color-swatch color-swatch--accent1" aria-hidden="true"></span>
              <span>Accent 1</span>
            </div>
            <div class="color-select-option" role="option" data-value="accent2" tabindex="0">
              <span class="color-swatch color-swatch--accent2" aria-hidden="true"></span>
              <span>Accent 2</span>
            </div>
            <div class="color-select-option" role="option" data-value="accent3" tabindex="0">
              <span class="color-swatch color-swatch--accent3" aria-hidden="true"></span>
              <span>Accent 3</span>
            </div>
          </div>
        </div>
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

    /* Service Worker for offline mode */
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('sw.js').catch(function() {});
    }

    /* Offline indicator – show when network or server unavailable */
    (function initOfflineIndicator() {
      var indicator = document.getElementById('offlineIndicator');
      if (!indicator) return;
      var serverUnavailable = false;
      var simulateOffline = false;
      function updateIndicator() {
        var show = !navigator.onLine || serverUnavailable || simulateOffline;
        indicator.classList.toggle('visible', show);
      }
      window.addEventListener('online', function() {
        if (!simulateOffline) serverUnavailable = false;
        updateIndicator();
      });
      window.addEventListener('offline', updateIndicator);
      updateIndicator();
      window._setServerUnavailable = function(v) {
        if (!simulateOffline) serverUnavailable = !!v;
        updateIndicator();
      };
      window._toggleSimulateOffline = function() {
        simulateOffline = !simulateOffline;
        updateIndicator();
      };
      /* Periodic check when we think we're offline (server was unreachable) */
      setInterval(function() {
        if (simulateOffline) return;
        if (serverUnavailable && navigator.onLine) {
          fetch('api.php?action=get', { method: 'GET' }).then(function(r) {
            if (r.ok) window._setServerUnavailable(false);
          }).catch(function() {});
        }
      }, 30000);
    })();

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
      catppuccin: 'Catppuccin Mocha',
      'catppuccin-latte': 'Catppuccin Latte',
      everforest: 'Everforest',
      'tokyo-night': 'Tokyo Night',
      sms: 'INSERT CART',
      gb: 'NINTENDO',
      ps5: 'PlayStation',
      lcars: 'Star Trek TNG',
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

    (function initHelpModal() {
      const helpCharmBtn = document.getElementById('helpCharmBtn');
      const helpModal = document.getElementById('helpModal');
      const helpModalCloseBtn = document.getElementById('helpModalCloseBtn');
      if (helpCharmBtn) {
        helpCharmBtn.addEventListener('click', function() {
          if (helpModal) helpModal.classList.add('open');
        });
      }
      if (helpModalCloseBtn) helpModalCloseBtn.addEventListener('click', function() { if (helpModal) helpModal.classList.remove('open'); });
      if (helpModal) helpModal.addEventListener('click', function(e) { if (e.target === helpModal) helpModal.classList.remove('open'); });
    })();

    (function initThemeShortcut() {
      var THEME_ORDER = ['megadrive', 'tron', 'tron-ares', 'matrix', 'catppuccin', 'catppuccin-latte', 'everforest', 'tokyo-night', 'sms', 'gb', 'ps5', 'lcars', 'macintosh', 'msdos'];
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          var openModals = document.querySelectorAll('.modal-overlay.open');
          if (openModals.length > 0) {
            e.preventDefault();
            var eventModal = document.getElementById('eventNotificationModal');
            if (eventModal && eventModal.classList.contains('open')) {
              var dismissBtn = document.getElementById('eventNotificationDismissBtn');
              if (dismissBtn) dismissBtn.click();
            }
            var tetrisO = document.getElementById('tetrisGameOverlay');
            var snakeO = document.getElementById('snakeGameOverlay');
            if (tetrisO && tetrisO.classList.contains('open') && window._tetrisStop) window._tetrisStop();
            if (snakeO && snakeO.classList.contains('open') && window._snakeStop) window._snakeStop();
            openModals.forEach(function(m) { m.classList.remove('open'); });
          }
          return;
        }
        if (e.altKey && e.shiftKey && (e.key === 'E' || e.key === 'e')) {
          e.preventDefault();
          e.stopPropagation();
          if (window._showTestEventModal) window._showTestEventModal();
        }
        if (e.altKey && e.shiftKey && (e.key === 'S' || e.key === 's')) {
          e.preventDefault();
          e.stopImmediatePropagation();
          if (window._enterScreensaver) window._enterScreensaver(true);
        }
        if (e.altKey && e.shiftKey && (e.key === 'T' || e.key === 't')) {
          e.preventDefault();
          e.stopPropagation();
          var current = html.getAttribute('data-theme') || 'megadrive';
          var idx = THEME_ORDER.indexOf(current);
          var next = THEME_ORDER[(idx + 1) % THEME_ORDER.length];
          if (themeSelect) {
            themeSelect.value = next;
            themeSelect.dispatchEvent(new Event('change'));
          }
        }
        if (e.altKey && e.shiftKey && (e.key === 'O' || e.key === 'o')) {
          e.preventDefault();
          e.stopPropagation();
          if (window._toggleSimulateOffline) window._toggleSimulateOffline();
        }
        if (e.altKey && e.shiftKey && (e.key === 'F' || e.key === 'f')) {
          e.preventDefault();
          e.stopPropagation();
          var fs = document.getElementById('fullscreenCharmBtn');
          if (fs && document.documentElement.requestFullscreen) {
            if (document.fullscreenElement) document.exitFullscreen();
            else document.documentElement.requestFullscreen();
          }
        }
        if (e.altKey && e.shiftKey && (e.key === 'M' || e.key === 'm')) {
          e.preventDefault();
          e.stopPropagation();
          var btn = document.getElementById('musicCharmBtnTray');
          if (btn) btn.click();
        }
        if (e.altKey && e.shiftKey && (e.key === 'H' || e.key === 'h')) {
          e.preventDefault();
          e.stopPropagation();
          var hm = document.getElementById('helpModal');
          if (hm) hm.classList.add('open');
        }
        if (e.altKey && e.shiftKey && (e.key === 'D' || e.key === 'd')) {
          e.preventDefault();
          e.stopPropagation();
          var app = document.getElementById('app');
          var emb = document.getElementById('editModeBtn');
          if (app && emb) {
            app.classList.toggle('edit-mode');
            emb.classList.toggle('active', app.classList.contains('edit-mode'));
            emb.dataset.tooltip = app.classList.contains('edit-mode') ? 'Done (Alt+Shift+D)' : 'Edit (Alt+Shift+D)';
          }
        }
        if (e.altKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) {
          e.preventDefault();
          e.stopPropagation();
          var ch = document.getElementById('charmsHamburgerBtn');
          if (ch) ch.focus();
        }
        if (e.altKey && e.shiftKey && (e.key === 'G' || e.key === 'g')) {
          e.preventDefault();
          e.stopPropagation();
          if (window._openGameMenu) window._openGameMenu();
        }
      });
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
        if (includeEditBtn) return `<div class="day-bar-wrap"><button class="edit-blocks-btn" type="button" id="editBlocksBtn" data-tooltip="Edit daily events">Edit events</button><div class="day-bar">${core}</div></div>`;
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
        return `<div class="day-bar-wrap"><button class="edit-blocks-btn" type="button" id="editBlocksBtn" data-tooltip="Edit time blocks">Edit blocks</button><div class="day-bar">${coreHtml}</div></div>`;
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

    (function initEventNotifications() {
      const EVENT_MODAL_DURATION_MS = 30000;
      const EVENT_MODAL_DURATION_SEC = 30;
      let eventsShownToday = new Set();
      let pendingEventNotification = null;
      let eventModalCountdownInterval = null;
      let eventModalAutoCloseTimeout = null;

      const modal = document.getElementById('eventNotificationModal');
      const titleEl = document.getElementById('eventNotificationTitle');
      const timeEl = document.getElementById('eventNotificationTime');
      const progressFill = document.getElementById('eventNotificationProgressFill');
      const countdownEl = document.getElementById('eventNotificationCountdown');
      const dismissBtn = document.getElementById('eventNotificationDismissBtn');

      function eventKey(block) {
        const d = new Date();
        const y = d.getFullYear(), m = d.getMonth(), day = d.getDate();
        const t = Math.round((block.time ?? block.start ?? 0) * 60);
        return y + '-' + m + '-' + day + '-' + t + '-' + (block.id || block.label || '');
      }

      function closeEventModal() {
        if (!modal) return;
        modal.classList.remove('open');
        if (progressFill) {
          progressFill.classList.remove('countdown-active');
          progressFill.style.width = '100%';
        }
        if (eventModalCountdownInterval) {
          clearInterval(eventModalCountdownInterval);
          eventModalCountdownInterval = null;
        }
        if (eventModalAutoCloseTimeout) {
          clearTimeout(eventModalAutoCloseTimeout);
          eventModalAutoCloseTimeout = null;
        }
      }

      function showEventNotification(block) {
        if (!modal || !titleEl || !timeEl || !progressFill || !countdownEl) return;
        const label = block.label || block.name || block.title || 'Event';
        const timeStr = decimalToTimeStr(block.time ?? block.start ?? 0);
        titleEl.textContent = label;
        timeEl.textContent = 'Time: ' + timeStr;
        modal.classList.add('open');
        let remainingSec = EVENT_MODAL_DURATION_SEC;
        progressFill.classList.remove('countdown-active');
        progressFill.style.width = '100%';
        progressFill.offsetHeight;
        progressFill.classList.add('countdown-active');
        countdownEl.textContent = 'Closing in ' + remainingSec + 's';
        if (modal.querySelector('[role="progressbar"]')) {
          modal.querySelector('[role="progressbar"]').setAttribute('aria-valuenow', remainingSec);
        }
        eventModalCountdownInterval = setInterval(function() {
          remainingSec--;
          if (remainingSec <= 0) {
            closeEventModal();
            return;
          }
          countdownEl.textContent = 'Closing in ' + remainingSec + 's';
          const bar = modal.querySelector('[role="progressbar"]');
          if (bar) bar.setAttribute('aria-valuenow', remainingSec);
        }, 1000);
        eventModalAutoCloseTimeout = setTimeout(closeEventModal, EVENT_MODAL_DURATION_MS);
      }

      function triggerEventNotification(block) {
        if (window._screensaverActive) {
          pendingEventNotification = { block: block };
          return;
        }
        showEventNotification(block);
      }

      window._showPendingEventNotification = function() {
        if (pendingEventNotification) {
          const block = pendingEventNotification.block;
          pendingEventNotification = null;
          showEventNotification(block);
        }
      };

      window._showTestEventModal = function() {
        const now = new Date();
        const h = now.getHours(), m = now.getMinutes();
        showEventNotification({ label: 'Test Event', time: h + m / 60 });
      };

      if (dismissBtn) {
        dismissBtn.addEventListener('click', closeEventModal);
      }

      setInterval(function() {
        const blocks = getTimeBlocks();
        if (!blocks.length) return;
        const now = new Date();
        const mins = minsSinceMidnight(now.getHours(), now.getMinutes());
        const todayPrefix = now.getFullYear() + '-' + now.getMonth() + '-' + now.getDate() + '-';
        if (eventsShownToday.size > 0) {
          const keys = Array.from(eventsShownToday);
          eventsShownToday = new Set(keys.filter(function(k) { return k.startsWith(todayPrefix); }));
        }
        for (let i = 0; i < blocks.length; i++) {
          const block = blocks[i];
          const blockMins = Math.round((block.time ?? block.start ?? 0) * 60);
          if (mins !== blockMins) continue;
          const key = eventKey(block);
          if (eventsShownToday.has(key)) continue;
          eventsShownToday.add(key);
          triggerEventNotification(block);
          break;
        }
      }, 1000);
    })();

    (function initScreensaver() {
      const IDLE_MS = 60000;
      const overlay = document.getElementById('screensaverOverlay');
      const mystifyCanvas = document.getElementById('screensaverMystify');
      const screensaverClock = document.getElementById('screensaverClock');
      const screensaverDayBars = document.getElementById('screensaverDayBars');
      let idleTimer = null;
      let mystifyRAF = null;
      let mystifyTimeout = null;
      let mystifyLastDraw = 0;
      let mystifyPoints = [];
      let mystifyHistory = [];
      let mystifyCachedColors = null;
      let mystifyCtx = null;
      let manualActivationGraceUntil = 0;
      let modalsOpenBeforeScreensaver = [];

      const MYSTIFY_THEME = {
        ps5: { fps: 30, scale: 1 },
        tron: { fps: 30, scale: 1 },
        'tron-ares': { fps: 30, scale: 1 },
        megadrive: { fps: 15, scale: 0.75 },
        sms: { fps: 15, scale: 0.75 },
        gb: { fps: 10, scale: 0.5 },
        matrix: { fps: 10, scale: 0.5 },
        lcars: { fps: 30, scale: 1 },
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

      function refreshMystifyCachedColors() {
        const bg = getComputedStyle(document.documentElement).getPropertyValue('--bg').trim() || '#1a1630';
        const content = getComputedStyle(document.documentElement).getPropertyValue('--content').trim() || '#e0e0ff';
        const bgRgb = bg.startsWith('#') ? hexToRgb(bg) : parseRgb(bg);
        const contentRgb = content.startsWith('#') ? hexToRgb(content) : parseRgb(content);
        mystifyCachedColors = {
          bgStyle: bgRgb ? 'rgb(' + bgRgb.r + ',' + bgRgb.g + ',' + bgRgb.b + ')' : '#1a1630',
          baseRgb: contentRgb ? (contentRgb.r + ',' + contentRgb.g + ',' + contentRgb.b) : '224,224,255'
        };
      }

      function drawMystify(now) {
        if (!mystifyCanvas || !overlay.classList.contains('active')) return;
        now = now || performance.now();
        const cfg = getMystifyThemeConfig();
        const frameInterval = 1000 / cfg.fps;
        if (now - mystifyLastDraw < frameInterval) {
          if (cfg.fps <= 15) {
            mystifyTimeout = setTimeout(function() { drawMystify(performance.now()); }, Math.ceil(frameInterval));
          } else {
            mystifyRAF = requestAnimationFrame(drawMystify);
          }
          return;
        }
        mystifyLastDraw = now;
        const ctx = mystifyCtx || mystifyCanvas.getContext('2d');
        if (!mystifyCtx) mystifyCtx = ctx;
        const dpr = window.devicePixelRatio || 1;
        const scale = cfg.scale;
        const w = mystifyCanvas.width / (dpr * scale);
        const h = mystifyCanvas.height / (dpr * scale);
        if (!mystifyCachedColors) refreshMystifyCachedColors();
        ctx.fillStyle = mystifyCachedColors.bgStyle;
        ctx.fillRect(0, 0, w, h);
        const baseRgb = mystifyCachedColors.baseRgb;
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
        if (cfg.fps <= 15) {
          mystifyTimeout = setTimeout(function() { drawMystify(performance.now()); }, Math.ceil(frameInterval));
        } else {
          mystifyRAF = requestAnimationFrame(drawMystify);
        }
      }
      function hexToRgb(hex) {
        const m = hex.slice(1).match(/.{2}/g);
        return m ? { r: parseInt(m[0], 16), g: parseInt(m[1], 16), b: parseInt(m[2], 16) } : null;
      }
      function parseRgb(s) {
        const m = s.match(/\d+/g);
        return m && m.length >= 3 ? { r: +m[0], g: +m[1], b: +m[2] } : null;
      }

      var resizeMystifyDebounceTimer = null;
      function resizeMystify() {
        if (!mystifyCanvas || !overlay) return;
        if (overlay.classList.contains('active')) {
          if (resizeMystifyDebounceTimer) clearTimeout(resizeMystifyDebounceTimer);
          resizeMystifyDebounceTimer = setTimeout(function doResize() {
            resizeMystifyDebounceTimer = null;
            resizeMystifyInner();
          }, 120);
          return;
        }
        resizeMystifyInner();
      }
      function resizeMystifyInner() {
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
        mystifyCachedColors = null;
      }

      function enterScreensaver(manualActivation) {
        if (window._screensaverActive) return;
        window._screensaverActive = true;
        manualActivationGraceUntil = manualActivation ? Date.now() + 2000 : 0;
        window._screensaverClockEl = screensaverClock;
        window._screensaverDayBarsEl = screensaverDayBars;
        modalsOpenBeforeScreensaver = [];
        document.querySelectorAll('.modal-overlay.open').forEach(function(m) {
          if (m.id === 'eventNotificationModal') return;
          modalsOpenBeforeScreensaver.push(m.id || m);
          m.classList.remove('open');
        });
        document.body.classList.add('screensaver-active');
        overlay.classList.add('active');
        overlay.setAttribute('aria-hidden', 'false');
        mystifyHistory = [];
        mystifyLastDraw = 0;
        mystifyCachedColors = null;
        refreshMystifyCachedColors();
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
        if (window._showPendingEventNotification) window._showPendingEventNotification();
        if (mystifyRAF) {
          cancelAnimationFrame(mystifyRAF);
          mystifyRAF = null;
        }
        if (mystifyTimeout) {
          clearTimeout(mystifyTimeout);
          mystifyTimeout = null;
        }
      }

      window._enterScreensaver = function(manual) { enterScreensaver(manual); };
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
          if (overlay && overlay.classList.contains('active')) {
            mystifyCachedColors = null;
            resizeMystify();
          }
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
    const modalItemUrl = document.getElementById('modalItemUrl');
    const modalItemColor = document.getElementById('modalItemColor');
    const modalCancelBtn = document.getElementById('modalCancelBtn');
    const modalSaveBtn = document.getElementById('modalSaveBtn');
    const colorSelectTrigger = document.getElementById('colorSelectTrigger');
    const colorSelectDropdown = document.getElementById('colorSelectDropdown');

    function syncColorSelectDisplay() {
      if (!modalItemColor) return;
      var val = modalItemColor.value || '';
      var labels = { '': 'None', accent1: 'Accent 1', accent2: 'Accent 2', accent3: 'Accent 3' };
      if (colorSelectTrigger) {
        var lbl = colorSelectTrigger.querySelector('.color-select-label');
        var swatch = colorSelectTrigger.querySelector('.color-swatch');
        if (lbl) lbl.textContent = labels[val] || 'None';
        if (swatch) swatch.className = 'color-swatch color-swatch--' + (val || 'none');
      }
      if (colorSelectDropdown) {
        colorSelectDropdown.querySelectorAll('.color-select-option').forEach(function(opt) {
          opt.setAttribute('aria-selected', opt.dataset.value === val ? 'true' : 'false');
        });
      }
    }
    (function initColorSelect() {
      if (!colorSelectTrigger || !colorSelectDropdown || !modalItemColor) return;
      colorSelectTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        var open = !colorSelectDropdown.hidden;
        colorSelectDropdown.hidden = open;
        colorSelectTrigger.setAttribute('aria-expanded', !open);
        if (!open) colorSelectDropdown.querySelector('.color-select-option').focus();
      });
      colorSelectDropdown.querySelectorAll('.color-select-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
          modalItemColor.value = opt.dataset.value || '';
          syncColorSelectDisplay();
          colorSelectDropdown.hidden = true;
          colorSelectTrigger.setAttribute('aria-expanded', 'false');
        });
        opt.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); opt.click(); }
          if (e.key === 'Escape') {
            colorSelectDropdown.hidden = true;
            colorSelectTrigger.setAttribute('aria-expanded', 'false');
            colorSelectTrigger.focus();
          }
        });
      });
      document.addEventListener('click', function(e) {
        if (colorSelectDropdown && !colorSelectDropdown.hidden &&
            !colorSelectTrigger.contains(e.target) && !colorSelectDropdown.contains(e.target)) {
          colorSelectDropdown.hidden = true;
          colorSelectTrigger.setAttribute('aria-expanded', 'false');
        }
      });
      syncColorSelectDisplay();
    })();

    function api(action, body) {
      const opts = { method: body ? 'POST' : 'GET' };
      let url = 'api.php?action=' + action;
      if (!body && action === 'get') url += '&_=' + Date.now();
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

    function normalizePaletteColor(c) {
      if (!c) return '';
      const map = { dev: 'accent1', nhs: 'accent2', private: 'accent3' };
      return map[c] || (c === 'accent1' || c === 'accent2' || c === 'accent3' ? c : '');
    }
    function renderCard(item, categoryId) {
      const color = normalizePaletteColor(item.color);
      const colorClass = color ? ' link-card--' + color : '';
      return `
        <div class="link-card${colorClass}" data-id="${item.id}" data-category-id="${categoryId}" data-href="${item.url}">
          <div class="link-card-content">
            <span class="link-title">${escapeHtml(item.title)}</span>
          </div>
          <div class="link-actions">
            <button class="edit-item-btn" type="button" data-tooltip="Edit">✎</button>
            <button class="delete-item-btn" type="button" data-tooltip="Delete">✕</button>
            <a class="link-icon" href="${escapeHtml(item.url)}" target="_blank" rel="noopener" data-tooltip="Visit">Visit</a>
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
      if (!itemIds.length) return;
      var cat = data.categories && data.categories.find(function(c) { return c.id === categoryId; });
      if (cat && cat.items && cat.items.length) {
        var ordered = [];
        for (var i = 0; i < itemIds.length; i++) {
          var item = cat.items.find(function(it) { return it.id === itemIds[i]; });
          if (item) ordered.push(item);
        }
        cat.items = ordered;
        cat.items.forEach(function(item, idx) { item.order = idx; });
      }
      render();
      api('reorder', { action: 'reorder', categoryId: categoryId, itemIds: itemIds }).catch(function(err) {
        load();
        alert('Could not save order. ' + (err && err.message ? err.message : 'Please try again.'));
      });
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
      modalItemUrl.value = '';
      modalItemColor.value = '';
      if (colorSelectDropdown) colorSelectDropdown.hidden = true;
      if (colorSelectTrigger) colorSelectTrigger.setAttribute('aria-expanded', 'false');
      syncColorSelectDisplay();
      itemModal.classList.add('open');
    }

    function openEditModal(itemId, categoryId) {
      const item = data.categories.flatMap(c => c.items || []).find(i => i.id === itemId);
      if (!item) return;
      modalTitleEl.textContent = 'Edit Item';
      modalItemId.value = itemId;
      modalCategoryId.value = categoryId;
      modalItemTitle.value = item.title;
      modalItemUrl.value = item.url;
      modalItemColor.value = normalizePaletteColor(item.color) || '';
      if (colorSelectDropdown) colorSelectDropdown.hidden = true;
      if (colorSelectTrigger) colorSelectTrigger.setAttribute('aria-expanded', 'false');
      syncColorSelectDisplay();
      itemModal.classList.add('open');
    }

    function closeModal() {
      itemModal.classList.remove('open');
    }

    function saveItem() {
      const id = modalItemId.value;
      const title = modalItemTitle.value.trim();
      const subtitle = '';
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
        if (window._setServerUnavailable) window._setServerUnavailable(false);
      }).catch(() => {
        render();
        if (window._midiPlayerTryRestore) window._midiPlayerTryRestore();
        if (window._setServerUnavailable) window._setServerUnavailable(true);
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
          ${isCustom ? '<button class="tb-edit" type="button" data-tooltip="Edit">Edit</button><button class="tb-delete" type="button" data-tooltip="Delete">Delete</button>' : ''}
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
      editModeBtn.dataset.tooltip = app.classList.contains('edit-mode') ? 'Done (Alt+Shift+D)' : 'Edit (Alt+Shift+D)';
    });

    (function initScratchPad() {
      const textEl = document.getElementById('scratchPadText');
      const basicEl = document.getElementById('scratchPadBasic');
      const textTab = document.getElementById('scratchPadTextTab');
      const basicTab = document.getElementById('scratchPadBasicTab');
      const stopBtn = document.getElementById('scratchPadStopBtn');
      let activeTab = 'text';
      let textContent = '';
      let basicContent = '';
      let isStreaming = false;
      let streamTimeoutId = null;
      let stateBeforeRun = '';
      let stateBeforeOutput = '';
      let hasOutputFromRun = false;
      function getBlockContainingCaret() {
        const sel = window.getSelection();
        if (!sel || sel.rangeCount === 0) return null;
        let node = sel.anchorNode || sel.focusNode;
        if (!node || !textEl.contains(node)) return null;
        while (node && node !== textEl) {
          if (node.parentNode === textEl && node.nodeType === 1) {
            var tag = node.tagName ? node.tagName.toUpperCase() : '';
            if (tag === 'DIV' || tag === 'P') return node;
          }
          node = node.parentNode;
        }
        var first = textEl.querySelector(':scope > div, :scope > p');
        return first || null;
      }
      function convertLineToCheckbox(block, checked, textAfter) {
        const rest = textAfter != null ? textAfter : ((block.querySelector('.scratch-pad-line-text') || {}).textContent || (block.textContent || '').trim());
        const label = document.createElement('label');
        label.style.display = 'flex';
        label.style.alignItems = 'center';
        label.style.gap = '0.35rem';
        label.style.flex = '1';
        label.style.flexWrap = 'nowrap';
        const cb = document.createElement('input');
        cb.type = 'checkbox';
        cb.checked = !!checked;
        cb.contentEditable = 'false';
        const textSpan = document.createElement('span');
        textSpan.className = 'scratch-pad-line-text';
        textSpan.textContent = rest || '';
        label.appendChild(cb);
        label.appendChild(textSpan);
        block.innerHTML = '';
        block.className = 'scratch-pad-line';
        block.appendChild(label);
        return textSpan;
      }
      function tryConvertCurrentLineOnEnter() {
        const block = getBlockContainingCaret();
        if (!block || !block.parentNode) return null;
        const text = (block.textContent || '').trim();
        const mBracket = text.match(/^\s*\[\s?([xX]?)\s?\]\s*(.*)$/);
        const mDash = text.match(/^\s*-\s+(.*)$/);
        if (mBracket) {
          convertLineToCheckbox(block, /[xX]/.test(mBracket[1]), mBracket[2] || '');
          return block;
        }
        if (mDash) {
          convertLineToCheckbox(block, false, mDash[1] || '');
          return block;
        }
        return null;
      }
      function isCursorAtStartOfCheckboxLine(block) {
        if (!block) return false;
        const span = block.querySelector('.scratch-pad-line-text');
        if (!span) return false;
        const sel = window.getSelection();
        if (!sel || sel.rangeCount === 0) return false;
        let node = sel.anchorNode;
        if (!node) return false;
        if (!span.contains(node) && node !== span) return false;
        if (node === span) return sel.anchorOffset === 0;
        while (node && node !== span) { node = node.parentNode; }
        if (node !== span) return false;
        const range = sel.getRangeAt(0);
        const preCaret = range.cloneRange();
        preCaret.selectNodeContents(span);
        preCaret.setEnd(range.startContainer, range.startOffset);
        return preCaret.toString().length === 0;
      }
      function convertCheckboxLineToPlainText(block) {
        const cb = block.querySelector('input[type="checkbox"]');
        const span = block.querySelector('.scratch-pad-line-text');
        if (!cb || !span) return false;
        const text = span.textContent || '';
        const prefix = cb.checked ? '[x] ' : '[ ] ';
        block.innerHTML = '';
        block.className = 'scratch-pad-line';
        block.textContent = prefix + text;
        const range = document.createRange();
        range.setStart(block.firstChild, prefix.length);
        range.collapse(true);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        return true;
      }
      function serializeTextEditor() {
        const lines = [];
        const blocks = textEl.querySelectorAll(':scope > div, :scope > p');
        if (blocks.length) {
          blocks.forEach(function(block) {
            const cb = block.querySelector('input[type="checkbox"]');
            const textSpan = block.querySelector('.scratch-pad-line-text');
            const rest = textSpan ? textSpan.textContent : (block.textContent || '').trim();
            if (cb) lines.push((cb.checked ? '[x] ' : '[ ] ') + rest);
            else lines.push(rest);
          });
        } else {
          const raw = (textEl.innerText || '').split(/\r?\n/);
          raw.forEach(function(line) {
            const m = line.match(/^\s*\[\s?([xX]?)\s?\]\s*(.*)$/);
            if (m) lines.push((m[1] ? '[x] ' : '[ ] ') + m[2]);
            else if (line.match(/^\s*-\s+/)) lines.push('[ ] ' + line.replace(/^\s*-\s+/, ''));
            else lines.push(line);
          });
        }
        return lines.join('\n');
      }
      function deserializeTextEditor(text) {
        const lines = (text || '').split(/\r?\n/);
        const frag = document.createDocumentFragment();
        lines.forEach(function(line) {
          const div = document.createElement('div');
          div.className = 'scratch-pad-line';
          const mBracket = line.match(/^\s*\[\s?([xX]?)\s?\]\s*(.*)$/);
          const mDash = line.match(/^\s*-\s+(.*)$/);
          if (mBracket) {
            const checked = /[xX]/.test(mBracket[1]);
            const label = document.createElement('label');
            label.style.display = 'flex';
            label.style.alignItems = 'center';
            label.style.gap = '0.35rem';
            label.style.flex = '1';
            label.style.flexWrap = 'nowrap';
            const cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.checked = checked;
            cb.contentEditable = 'false';
            const span = document.createElement('span');
            span.className = 'scratch-pad-line-text';
            span.textContent = mBracket[2] || '';
            span.contentEditable = 'true';
            label.appendChild(cb);
            label.appendChild(span);
            div.appendChild(label);
          } else if (mDash) {
            const label = document.createElement('label');
            label.style.display = 'flex';
            label.style.alignItems = 'center';
            label.style.gap = '0.35rem';
            label.style.flex = '1';
            label.style.flexWrap = 'nowrap';
            const cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.contentEditable = 'false';
            const span = document.createElement('span');
            span.className = 'scratch-pad-line-text';
            span.textContent = mDash[1] || '';
            span.contentEditable = 'true';
            label.appendChild(cb);
            label.appendChild(span);
            div.appendChild(label);
          } else {
            div.textContent = line;
          }
          frag.appendChild(div);
        });
        textEl.innerHTML = '';
        textEl.appendChild(frag);
      }
      try {
        const legacy = localStorage.getItem('devStartPageScratch') || '';
        textContent = localStorage.getItem('devStartPageScratchText') || '';
        basicContent = localStorage.getItem('devStartPageScratchBasic') || '';
        activeTab = localStorage.getItem('devStartPageScratchTab') || 'text';
        if (activeTab === 'javascript') activeTab = 'text';
        if (legacy && !textContent && !basicContent) {
          textContent = legacy;
          basicContent = legacy;
        }
      } catch (e) {}
      function saveContent() {
        if (activeTab === 'text') textContent = serializeTextEditor();
        else if (activeTab === 'basic') basicContent = basicEl.value;
        try {
          localStorage.setItem('devStartPageScratchText', textContent);
          localStorage.setItem('devStartPageScratchBasic', basicContent);
        } catch (e) {}
      }
      let initialLoad = true;
      function switchTab(tab) {
        if (!initialLoad) saveContent();
        initialLoad = false;
        activeTab = tab;
        try { localStorage.setItem('devStartPageScratchTab', activeTab); } catch (e) {}
        if (tab === 'text') {
          textEl.style.display = '';
          basicEl.style.display = 'none';
          deserializeTextEditor(textContent);
          basicEl.value = basicContent;
        } else {
          textEl.style.display = 'none';
          basicEl.style.display = '';
          basicEl.value = basicContent;
          basicEl.placeholder = '10 PRINT "Hello"\n20 GOTO 10\nRUN';
        }
        textTab.classList.toggle('active', tab === 'text');
        basicTab.classList.toggle('active', tab === 'basic');
        updateActionButtons();
      }
      function updateActionButtons() {
        const inBasic = activeTab === 'basic';
        const showStopBtn = inBasic && (isStreaming || hasOutputFromRun);
        if (stopBtn) {
          stopBtn.style.display = showStopBtn ? '' : 'none';
          stopBtn.textContent = isStreaming ? 'STOP' : 'RESET';
          stopBtn.title = isStreaming ? 'Stop execution' : 'Reset to before RUN';
        }
      }
      textEl.addEventListener('input', saveContent);
      textEl.addEventListener('keydown', function(e) {
        if (activeTab !== 'text') return;
        if (e.key === 'Backspace') {
          const block = getBlockContainingCaret();
          if (block && isCursorAtStartOfCheckboxLine(block)) {
            e.preventDefault();
            convertCheckboxLineToPlainText(block);
            saveContent();
          }
          return;
        }
        if (e.key !== 'Enter') return;
        const block = tryConvertCurrentLineOnEnter();
        if (block) {
          e.preventDefault();
          const newBlock = document.createElement('div');
          newBlock.className = 'scratch-pad-line';
          if (block.nextSibling) {
            textEl.insertBefore(newBlock, block.nextSibling);
          } else {
            textEl.appendChild(newBlock);
          }
          const sel = window.getSelection();
          const range = document.createRange();
          range.setStart(newBlock, 0);
          range.collapse(true);
          sel.removeAllRanges();
          sel.addRange(range);
          saveContent();
        }
      });
      basicEl.addEventListener('input', saveContent);
      if (textTab) textTab.addEventListener('click', () => switchTab('text'));
      if (basicTab) basicTab.addEventListener('click', () => switchTab('basic'));
      textEl.addEventListener('click', function(e) {
        if (e.target.type === 'checkbox') saveContent();
      });
      textEl.addEventListener('focus', function() {
        try { document.execCommand('defaultParagraphSeparator', false, 'div'); } catch (e) {}
      });
      switchTab(activeTab);

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

      basicEl.addEventListener('keydown', function(e) {
        if (e.key !== 'Enter' || activeTab !== 'basic' || isStreaming) return;
        const text = basicEl.value;
        const pos = basicEl.selectionStart;
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
        basicEl.value = stateBeforeOutput;
        basicEl.readOnly = true;
        isStreaming = true;
        updateActionButtons();
        let lineIdx = 0;
        function tick() {
          if (!isStreaming) return;
          if (lineIdx < lines.length) {
            const line = lines[lineIdx];
            const suffix = (lineIdx < lines.length - 1 || !output.endsWith('\n')) ? '\n' : '';
            basicEl.value += line + suffix;
            basicEl.scrollTop = basicEl.scrollHeight;
            lineIdx++;
          }
          if (lineIdx >= lines.length) {
            basicEl.value += after;
            basicEl.readOnly = false;
            basicContent = basicEl.value;
            saveContent();
            isStreaming = false;
            hasOutputFromRun = true;
            updateActionButtons();
            basicEl.selectionStart = basicEl.selectionEnd = basicEl.value.length;
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
            basicEl.readOnly = false;
            hasOutputFromRun = true;
            basicContent = basicEl.value;
            saveContent();
          } else if (hasOutputFromRun) {
            basicEl.value = stateBeforeOutput;
            basicEl.selectionStart = basicEl.selectionEnd = stateBeforeOutput.length;
            basicContent = basicEl.value;
            hasOutputFromRun = false;
            saveContent();
          }
          updateActionButtons();
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

      const fullscreenBtn = document.getElementById('fullscreenCharmBtn');
      if (fullscreenBtn && document.documentElement.requestFullscreen) {
        function updateFullscreenIcon() {
          const isFull = !!document.fullscreenElement;
          fullscreenBtn.textContent = isFull ? '\u2921' : '\u26B6';
          fullscreenBtn.dataset.tooltip = isFull ? 'Exit fullscreen (Alt+Shift+F)' : 'Fullscreen (Alt+Shift+F)';
          fullscreenBtn.setAttribute('aria-label', isFull ? 'Exit fullscreen' : 'Fullscreen');
        }
        fullscreenBtn.addEventListener('click', function() {
          if (document.fullscreenElement) {
            document.exitFullscreen();
          } else {
            document.documentElement.requestFullscreen();
          }
        });
        document.addEventListener('fullscreenchange', updateFullscreenIcon);
        updateFullscreenIcon();
      } else if (fullscreenBtn) {
        fullscreenBtn.style.display = 'none';
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
      const musicCharmBtnTray = document.getElementById('musicCharmBtnTray');
      const stopMusicBtn = document.getElementById('stopMusicBtn');
      const charmsMenu = document.querySelector('.charms-menu');
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
        if (charmsMenu) charmsMenu.classList.toggle('music-playing', midiPlaying);
        if (musicCharmBtnTray) {
          if (midiPlaying) {
            var tracks = getPlaylist();
            var track = tracks[midiCurrentTrackIndex];
            var trackName = track ? (track.name || track.url) : '';
            musicCharmBtnTray.textContent = '\u25B6';
            musicCharmBtnTray.classList.add('music-charm-playing');
            musicCharmBtnTray.title = trackName ? 'Now playing: ' + trackName : 'Music controls';
            musicCharmBtnTray.setAttribute('aria-label', trackName ? 'Now playing: ' + trackName : 'Music controls');
          } else {
            musicCharmBtnTray.textContent = '\u266A';
            musicCharmBtnTray.classList.remove('music-charm-playing');
            musicCharmBtnTray.title = 'Music controls';
            musicCharmBtnTray.setAttribute('aria-label', 'Music controls');
          }
        }
        if (stopMusicBtn) stopMusicBtn.classList.toggle('visible', midiPlaying);
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

      function openMusicModal() {
        renderPlaylist();
        updateProgressBar();
        if (musicModal) musicModal.classList.add('open');
      }
      if (stopMusicBtn) {
        stopMusicBtn.addEventListener('click', stopMidi);
        stopMusicBtn.addEventListener('keydown', function(e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); stopMidi(); } });
      }
      if (musicCharmBtnTray) musicCharmBtnTray.addEventListener('click', openMusicModal);
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

    /* Hidden game menu and games (Alt+Shift+G) */
    (function initGames() {
      var gameMenuModal = document.getElementById('gameMenuModal');
      var tetrisOverlay = document.getElementById('tetrisGameOverlay');
      var snakeOverlay = document.getElementById('snakeGameOverlay');

      window._openGameMenu = function() {
        if (tetrisOverlay && tetrisOverlay.classList.contains('open')) { if (window._tetrisStop) window._tetrisStop(); tetrisOverlay.classList.remove('open'); }
        if (snakeOverlay && snakeOverlay.classList.contains('open')) { if (window._snakeStop) window._snakeStop(); snakeOverlay.classList.remove('open'); }
        if (gameMenuModal) gameMenuModal.classList.add('open');
      };

      function closeGameMenu() { if (gameMenuModal) gameMenuModal.classList.remove('open'); }

      document.getElementById('gameMenuCloseBtn').addEventListener('click', closeGameMenu);
      if (gameMenuModal) gameMenuModal.addEventListener('click', function(e) { if (e.target === gameMenuModal) closeGameMenu(); });

      document.getElementById('gameMenuTetrisBtn').addEventListener('click', function() {
        closeGameMenu();
        if (tetrisOverlay) tetrisOverlay.classList.add('open');
        if (window._tetrisStart) window._tetrisStart();
      });
      document.getElementById('gameMenuSnakeBtn').addEventListener('click', function() {
        closeGameMenu();
        if (snakeOverlay) snakeOverlay.classList.add('open');
        if (window._snakeStart) window._snakeStart();
      });

      document.getElementById('tetrisBackBtn').addEventListener('click', function() {
        if (window._tetrisStop) window._tetrisStop();
        if (tetrisOverlay) tetrisOverlay.classList.remove('open');
        gameMenuModal.classList.add('open');
      });
      document.getElementById('snakeBackBtn').addEventListener('click', function() {
        if (window._snakeStop) window._snakeStop();
        if (snakeOverlay) snakeOverlay.classList.remove('open');
        gameMenuModal.classList.add('open');
      });
    })();

    /* Tetris - Game Boy style (10x18, 9 levels 0-9, Nintendo scoring) */
    (function initTetris() {
      var tetrisOverlay = document.getElementById('tetrisGameOverlay');
      var canvas = document.getElementById('tetrisCanvas');
      if (!canvas) return;
      var ctx = canvas.getContext('2d');
      var COLS = 10, ROWS = 18;
      var CELL = 20;
      canvas.width = COLS * CELL;
      canvas.height = ROWS * CELL;

      var GB_FRAMES = [53,49,45,41,37,33,28,22,17,11,10,9,8,7,6,6,5,5,4,4,3];
      var SHAPES = [
        [[1,1,1,1]],
        [[1,1],[1,1]],
        [[0,1,0],[1,1,1]],
        [[0,1,1],[1,1,0]],
        [[1,1,0],[0,1,1]],
        [[1,0,0],[1,1,1]],
        [[0,0,1],[1,1,1]]
      ];
      function getGameColors() {
        var s = getComputedStyle(document.documentElement);
        return {
          bg: (s.getPropertyValue('--game-board-bg') || '#0f380f').trim(),
          piece: (s.getPropertyValue('--game-piece') || '#9bbc0f').trim(),
          pieceLight: (s.getPropertyValue('--game-piece-light') || '#8bac0f').trim()
        };
      }

      var board = [], piece = null, px = 0, py = 0;
      var score = 0, level = 0, lines = 0;
      var gameLoop = null, frameCount = 0;
      var linesUntilLevel = 0;

      function initBoard() {
        board = [];
        for (var r = 0; r < ROWS; r++) {
          board[r] = [];
          for (var c = 0; c < COLS; c++) board[r][c] = 0;
        }
      }

      function newPiece() {
        var idx = Math.floor(Math.random() * SHAPES.length);
        piece = SHAPES[idx].map(function(row){ return row.slice(); });
        px = Math.floor((COLS - piece[0].length) / 2);
        py = 0;
        return !collide(px, py);
      }

      function collide(x, y) {
        for (var r = 0; r < piece.length; r++) {
          for (var c = 0; c < piece[r].length; c++) {
            if (piece[r][c]) {
              var nr = y + r, nc = x + c;
              if (nr < 0 || nc < 0 || nc >= COLS || nr >= ROWS) return true;
              if (nr >= 0 && board[nr][nc]) return true;
            }
          }
        }
        return false;
      }

      function lock() {
        for (var r = 0; r < piece.length; r++) {
          for (var c = 0; c < piece[r].length; c++) {
            if (piece[r][c]) board[py+r][px+c] = 1;
          }
        }
        var cleared = 0;
        for (var r = ROWS - 1; r >= 0; r--) {
          if (board[r].every(function(c){ return c; })) {
            board.splice(r, 1);
            board.unshift(Array(COLS).fill(0));
            cleared++; r++;
          }
        }
        if (cleared > 0) {
          var mult = level + 1;
          if (cleared === 1) score += 40 * mult;
          else if (cleared === 2) score += 100 * mult;
          else if (cleared === 3) score += 300 * mult;
          else score += 1200 * mult;
          lines += cleared;
          linesUntilLevel -= cleared;
          if (linesUntilLevel <= 0) {
            level = Math.min(20, level + 1);
            linesUntilLevel = 10;
          }
        }
        updateUI();
        if (!newPiece()) {
          piece = null;
          draw();
          var col = getGameColors();
          ctx.fillStyle = 'rgba(0,0,0,0.6)';
          ctx.fillRect(0, 0, canvas.width, canvas.height);
          ctx.fillStyle = col.piece;
          ctx.font = 'bold 24px monospace';
          ctx.textAlign = 'center';
          ctx.fillText('GAME OVER', canvas.width/2, canvas.height/2 - 10);
          ctx.font = '14px monospace';
          ctx.fillText('Click Back to return', canvas.width/2, canvas.height/2 + 20);
          return false;
        }
        return true;
      }

      function updateUI() {
        var se = document.getElementById('tetrisScore'), le = document.getElementById('tetrisLevel'), ln = document.getElementById('tetrisLines');
        if (se) se.textContent = score; if (le) le.textContent = level; if (ln) ln.textContent = lines;
      }

      function draw() {
        var col = getGameColors();
        ctx.fillStyle = col.bg;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        for (var r = 0; r < ROWS; r++) {
          for (var c = 0; c < COLS; c++) {
            if (board[r][c]) {
              ctx.fillStyle = col.pieceLight;
              ctx.fillRect(c*CELL+1, r*CELL+1, CELL-1, CELL-1);
              ctx.fillStyle = col.piece;
              ctx.fillRect(c*CELL+2, r*CELL+2, CELL-4, CELL-4);
            }
          }
        }
        if (piece) {
          ctx.fillStyle = col.piece;
          for (var r = 0; r < piece.length; r++) {
            for (var c = 0; c < piece[r].length; c++) {
              if (piece[r][c]) ctx.fillRect((px+c)*CELL+1, (py+r)*CELL+1, CELL-1, CELL-1);
            }
          }
        }
      }

      function tick() {
        frameCount++;
        var fpr = GB_FRAMES[Math.min(level, 20)];
        if (frameCount >= fpr) {
          frameCount = 0;
          if (!collide(px, py + 1)) py++;
          else {
            if (!lock()) { window._tetrisStop(); return; }
          }
        }
        draw();
      }

      window._tetrisStart = function() {
        if (gameLoop) return;
        initBoard();
        score = 0; level = 0; lines = 0; frameCount = 0;
        linesUntilLevel = 10;
        newPiece();
        updateUI();
        draw();
        gameLoop = setInterval(tick, 1000/60);
      };
      window._tetrisStop = function() {
        if (gameLoop) { clearInterval(gameLoop); gameLoop = null; }
      };

      document.addEventListener('keydown', function tetrisKey(e) {
        if (!tetrisOverlay || !tetrisOverlay.classList.contains('open')) return;
        if (!piece) return;
        if (e.key === 'ArrowLeft') { if (!collide(px-1, py)) px--; e.preventDefault(); }
        else if (e.key === 'ArrowRight') { if (!collide(px+1, py)) px++; e.preventDefault(); }
        else if (e.key === 'ArrowDown') {
          if (!collide(px, py+1)) { py++; score++; } else { lock(); }
          e.preventDefault();
        }
        else if (e.key === 'ArrowUp' || e.key === ' ') {
          var rot = [];
          for (var c = 0; c < piece[0].length; c++) {
            rot[c] = [];
            for (var r = piece.length-1; r >= 0; r--) rot[c].push(piece[r][c]);
          }
          if (!collide(px, py)) { piece = rot; }
          e.preventDefault();
        }
      });
    })();

    /* Snake - Nokia style (grid, 90° turns, eat & grow, die on wall/self) */
    (function initSnake() {
      var snakeOverlay = document.getElementById('snakeGameOverlay');
      var canvas = document.getElementById('snakeCanvas');
      if (!canvas) return;
      var ctx = canvas.getContext('2d');
      var GRID = 15;
      var CELL = 20;
      canvas.width = GRID * CELL;
      canvas.height = GRID * CELL;

      var snake = [], food = {x:0,y:0};
      var dir = {x:0,y:-1};
      var score = 0, gameLoop = null;

      function initGame() {
        snake = [{x:7,y:7},{x:7,y:8},{x:7,y:9}];
        dir = {x:0,y:-1};
        score = 0;
        spawnFood();
      }

      function spawnFood() {
        do {
          food.x = Math.floor(Math.random() * GRID);
          food.y = Math.floor(Math.random() * GRID);
        } while (snake.some(function(s){ return s.x === food.x && s.y === food.y; }));
      }

      function drawGameOver() {
        draw();
        var col = getGameColors();
        ctx.fillStyle = 'rgba(0,0,0,0.6)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = col.piece;
        ctx.font = 'bold 24px monospace';
        ctx.textAlign = 'center';
        ctx.fillText('GAME OVER', canvas.width/2, canvas.height/2 - 10);
        ctx.font = '14px monospace';
        ctx.fillText('Score: ' + score, canvas.width/2, canvas.height/2 + 20);
      }

      function tick() {
        var head = snake[0];
        var nx = head.x + dir.x, ny = head.y + dir.y;
        if (nx < 0 || nx >= GRID || ny < 0 || ny >= GRID) { drawGameOver(); window._snakeStop(); return; }
        if (snake.some(function(s){ return s.x === nx && s.y === ny; })) { drawGameOver(); window._snakeStop(); return; }
        snake.unshift({x:nx,y:ny});
        if (nx === food.x && ny === food.y) { score++; spawnFood(); }
        else snake.pop();
        var se = document.getElementById('snakeScore'); if (se) se.textContent = score;
        draw();
      }

      function getGameColors() {
        var s = getComputedStyle(document.documentElement);
        return {
          bg: (s.getPropertyValue('--game-board-bg') || '#0f380f').trim(),
          piece: (s.getPropertyValue('--game-piece') || '#9bbc0f').trim(),
          pieceLight: (s.getPropertyValue('--game-piece-light') || '#8bac0f').trim()
        };
      }

      function draw() {
        var col = getGameColors();
        ctx.fillStyle = col.bg;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = col.piece;
        snake.forEach(function(s) {
          ctx.fillRect(s.x*CELL+1, s.y*CELL+1, CELL-1, CELL-1);
        });
        ctx.fillStyle = col.pieceLight;
        ctx.beginPath();
        ctx.arc(food.x*CELL+CELL/2, food.y*CELL+CELL/2, CELL/2-2, 0, Math.PI*2);
        ctx.fill();
      }

      window._snakeStart = function() {
        if (gameLoop) return;
        initGame();
        var se = document.getElementById('snakeScore'); if (se) se.textContent = '0';
        draw();
        gameLoop = setInterval(tick, 120);
      };
      window._snakeStop = function() {
        if (gameLoop) { clearInterval(gameLoop); gameLoop = null; }
      };

      document.addEventListener('keydown', function snakeKey(e) {
        if (!snakeOverlay || !snakeOverlay.classList.contains('open')) return;
        if (!gameLoop) return;
        if (e.key === 'ArrowUp' && dir.y !== 1) { dir = {x:0,y:-1}; e.preventDefault(); }
        else if (e.key === 'ArrowDown' && dir.y !== -1) { dir = {x:0,y:1}; e.preventDefault(); }
        else if (e.key === 'ArrowLeft' && dir.x !== 1) { dir = {x:-1,y:0}; e.preventDefault(); }
        else if (e.key === 'ArrowRight' && dir.x !== -1) { dir = {x:1,y:0}; e.preventDefault(); }
      });
    })();

    render();
    load();
  })();
  </script>
</body>
</html>
