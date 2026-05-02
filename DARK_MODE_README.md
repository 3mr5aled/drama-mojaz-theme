# Dark Mode System - Implementation Guide

## Overview
Complete dark mode system for WordPress Sports News Theme with RTL Arabic support.

## Files Created

### CSS Files
1. **dark-mode-system.css** - Complete CSS variable system with light/dark themes
2. **dark-mode-toggle.css** - Professional toggle button styles with animations
3. **dark-mode-critical.css** - Critical CSS to prevent FOUC (Flash of Unstyled Content)
4. **dynamic-colors.css** (Updated) - Base color system with dark mode compatibility

### JavaScript Files
1. **dark-mode.js** - Complete dark mode controller with localStorage persistence

### PHP Updates
1. **functions.php** (Updated) - Enqueues new files and adds critical inline script

## File Load Order

```
1. dark-mode-critical.css (Inline in <head> - prevents FOUC)
2. Inline theme detection script (prevents flash)
3. dynamic-colors.css (base colors)
4. dark-mode-system.css (complete system)
5. dark-mode-toggle.css (toggle button)
6. dark-mode.js (controller)
7. header.css (your existing styles)
```

## How It Works

### 1. Critical CSS (Prevents Flash)
- Loaded immediately in `<head>` via inline style
- Checks localStorage for saved theme before page renders
- Applies dark class early to prevent white flash

### 2. CSS Variables System
- **Light Mode (Default)**: Clean, professional light theme
- **Dark Mode**: Deep navy backgrounds (#0a0f1a) with enhanced primary color (#ff4b55)
- All components use CSS variables that switch automatically

### 3. Tailwind Conflict Resolution
The system overrides Tailwind classes in dark mode:
- `.bg-white` → uses `--surface-1` (dark: #111827)
- `.bg-gray-50/100` → uses `--surface-2` (dark: #1e293b)
- `.text-black`, `.text-gray-900` → uses `--text-1` (dark: #f8fafc)
- `.border-gray-*` → uses `--border-1` (dark: #1e293b)

### 4. Toggle Button
- Moon icon (light mode) / Sun icon (dark mode)
- Smooth rotation animation
- Ripple effect on click
- Keyboard accessible (Enter/Space)

### 5. JavaScript Controller
- Saves preference to localStorage
- Detects system preference
- Smooth transitions between themes
- Exposes API: `window.DramaMojazDarkMode`

## Usage

### Basic Usage
The toggle button in header.php automatically works:
```html
<button id="darkModeToggle" aria-label="تبديل الوضع الداكن">
    <i class="ri-moon-line dark-mode-icon-moon"></i>
    <i class="ri-sun-line dark-mode-icon-sun" style="display:none;"></i>
</button>
```

### JavaScript API
```javascript
// Toggle theme
window.DramaMojazDarkMode.toggle();

// Set specific theme
window.DramaMojazDarkMode.set('dark');
window.DramaMojazDarkMode.set('light');

// Get current theme
const theme = window.DramaMojazDarkMode.get(); // 'dark' or 'light'

// Check if dark
const isDark = window.DramaMojazDarkMode.isDark(); // true or false
```

### Listen for Theme Changes
```javascript
document.addEventListener('dramamojaz:themechange', function(e) {
    console.log('Theme changed to:', e.detail.theme);
    console.log('Is dark:', e.detail.isDark);
});
```

## CSS Variable Reference

### Backgrounds
- `--bg-primary`: Main page background
- `--bg-secondary`: Secondary backgrounds
- `--surface-1`: Cards, widgets, main surfaces
- `--surface-2`: Elevated surfaces, hover states
- `--surface-3`: Active states, borders

### Text
- `--text-1`: Primary text (headings)
- `--text-2`: Secondary text (body)
- `--text-3`: Muted text (meta, captions)

### Borders
- `--border-1`: Default borders
- `--border-2`: Hover borders
- `--border-3`: Active borders

### Primary (Adaptive)
- Light mode: #E31B23
- Dark mode: #ff4b55 (brighter for visibility)

## Customization

### Change Primary Color in Dark Mode
Edit `dark-mode-system.css` line 115:
```css
html.dark {
    --primary: #your-color;
    --primary-rgb: R, G, B;
}
```

### Change Background Colors
Edit the surface variables in `dark-mode-system.css` under `html.dark`

### Adjust Transition Speed
Edit `assets/js/dark-mode.js` line 17:
```javascript
transitionDuration: 300 // milliseconds
```

## Troubleshooting

### White Flash on Page Load
- Critical CSS is already handling this
- Ensure `dark-mode-critical.css` is loaded inline in `<head>`
- Check that inline script runs before any other scripts

### Elements Not Adapting
- Make sure they use CSS variables (e.g., `color: var(--text-1)`)
- Check if Tailwind classes override variables (add `!important` if needed)
- Add specific selector to `dark-mode-system.css`

### Toggle Button Not Working
- Check browser console for JavaScript errors
- Ensure `dark-mode.js` is loaded
- Verify button has `id="darkModeToggle"`

## Browser Support
- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+
- IE11: Partial (no CSS variables support)

## RTL Support
Fully compatible with RTL layouts. All icons and animations work correctly in Arabic.

## Performance
- No FOUC (Flash of Unstyled Content)
- Smooth CSS transitions
- Minimal JavaScript footprint
- localStorage is fast and non-blocking
