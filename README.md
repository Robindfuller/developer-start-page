# Developer Start Page

A retro-styled developer start page with quick links, a visual day planner, and a scratch pad. Perfect as your browser's new tab or home page for fast access to dev tools, customer portals, and personal links.

## Features

- **Link categories**   Organize links into categories (Dev Environment, Live, etc.). Drag to reorder. Add, edit, delete in edit mode.
- **Visual day planner**   "Loading Next" progress bar shows where you are in the day based on configurable time blocks (Work Day, Tea Time, Lunch, Dog walk, etc.).
- **MIDI player**   Compact player widget next to the theme switcher. Add MIDI files via URL or upload, manage a playlist, play/pause/prev/next. Automatically advances to the next track when one finishes.
- **Theme switcher**   Nine themes: 16-bit Megadrive, Tron, Tron Ares (red), Matrix, Sega Master System, Game Boy, PlayStation 5, Macintosh (1984), MS-DOS.
- **Scratch pad**   Three tabs: **Text** for notes and quick thoughts; **Basic** for a built-in BASIC interpreter; **JavaScript** to run arbitrary JS (captures `console.log`). Maximize button (?) for full-screen editing.
- **Edit mode**   Toggle via the pencil button (bottom-right) to manage categories, items, and time blocks.
- **Screen saver**   Mystify-style bouncing-line animation. Activates after 60 seconds of idle time, or via the ? button (bottom-right). Shows clock and day planner. Theme-aware (different FPS/scale per theme). Move mouse or press a key to exit.

## Requirements

- PHP 7.0+ (or any PHP-capable web server)
- Web server (IIS, Apache, nginx, PHP built-in server)

## Setup

1. Clone or copy the project into your web root.
2. Optionally copy `data.json.example` to `data.json` for a starter layout or leave it out and add categories/links in the app (data.json will be created on first save).
3. Ensure `data.json` is writable by the web server (it will be created automatically when you add your first category).
4. Point your browser at the app (e.g. `http://localhost/ecgod-dev-start-page/`).

**Note:** `data.json` is gitignored. Your links and time blocks stay local and are not committed.

### IIS

The included `web.config` sets `index.php` as the default document for the root URL.

### Quick local test

```bash
php -S localhost:8080
```

Then open `http://localhost:8080` in your browser.

## MIDI Player

The MIDI player lets you listen to `.mid` / `.midi` files while using the start page. A compact player widget sits next to the theme switcher.

### Accessing the player

Click the music note (♪) button to open the playlist manager. Use the on-screen controls to play, pause, skip to previous/next, or close the panel.

### Adding tracks

| Method | Description |
|--------|-------------|
| **Add via URL** | Paste a URL to a MIDI file (e.g. from CDNs or your own server). |
| **Upload** | Upload `.mid` / `.midi` files; they are saved in the `midi/` folder. |

### Playlist controls

- **Play / Pause / Prev / Next** – Standard transport controls. Playback automatically advances to the next track when one finishes.
- **Remove** – Delete tracks from the playlist.
- **Reorder** – Drag tracks to change the playback order.

### Setup for uploads

- The `midi/` folder is created automatically when you upload your first file.
- Ensure the web server can write to the project directory (or create `midi/` manually with `mkdir midi` and make it writable).
- `midi/` is gitignored; your uploaded files stay local.

## Data

- **data.json**   Stores categories, link items, time blocks, and the MIDI playlist. Edits in the UI are persisted via `api.php`. Not committed to Git (see `.gitignore`).
- **data.json.example**   Sample structure. Copy to `data.json` to bootstrap, or start fresh and add categories in the app.
- **api.php**   REST-style API for add/edit/delete/reorder of items, categories, time blocks, and MIDI playlist.

## Scratch Pad

The scratch pad has three tabs, each with its own persisted content:

| Tab | Description |
|-----|--------------|
| **Text** | Plain notes, reminders, and quick thoughts. |
| **Basic** | Built-in BASIC interpreter (see below). |
| **JavaScript** | Run arbitrary JavaScript. Click **RUN** or press **Ctrl+Enter** to execute. Output from `console.log`, `console.warn`, and `console.error` is captured and appended below your code. |

Use the maximize button (?) to expand the scratch pad to full screen and hide the rest of the page.

## The BASIC Interpreter (Just for Fun)

In the **Basic** tab you get a mini BASIC interpreter so you can run classic-style programs right in the start page.

### How to run

1. Switch to the **Basic** tab in the scratch pad.
2. Type your program using line numbers.
3. Type `RUN` and press **Enter**.

Output streams in line-by-line. Use **STOP** to halt execution, or **RESET** to restore the editor state before the run.

### Supported syntax

| Command | Example |
|--------|---------|
| `PRINT` | `10 PRINT "Hello World"` |
| `PRINT` (expression) | `20 PRINT 2 + 2` |
| `GOTO` / `GO TO` | `30 GOTO 10` |
| `LET` | `40 LET X = 5` |
| Variable assignment | `50 X = 10` |
| `END` | `60 END` |

### Arithmetic

- Operators: `+`, `-`, `*`, `/`, `**` (exponentiation)
- Numbers: integers and decimals
- Variables: `A-Z`, `a-z`, `_`, digits (after first char)

### Example programs

Classic infinite loop:

```basic
10 PRINT "Hello"
20 GOTO 10
RUN
```

Variable and arithmetic:

```basic
10 LET X = 10
20 LET Y = 3
30 PRINT "X * Y ="
40 PRINT X * Y
50 END
RUN
```

### Limits

- Max 10,000 execution steps (prevents infinite loops from hanging the tab)
- Output truncated at 50,000 characters
- No `IF`, `FOR`, `INPUT`, or other advanced statements ? ? it's intentionally minimal

It's a nostalgic throwback: line numbers, `PRINT`, `GOTO`, and `LET` in a modern start page.

## Screen Saver

The screen saver shows a Mystify-style bouncing-line animation with the clock and day planner overlay. It:

- **Activates** after 60 seconds of inactivity, or immediately when you click the ? button (bottom-right).
- **Adapts to the current theme** ? different themes use different FPS and pixel scale (e.g. Game Boy runs at 10 FPS with chunky pixels; Tron runs at 60 FPS with smooth lines).
- **Exits** on any mouse movement, key press, touch, or scroll.

## License

Use freely for personal or internal projects.