# drama-mojaz-theme
# Drama Mojaz Theme - Comprehensive Documentation

Welcome to the **Drama Mojaz Theme** documentation. This document provides an exhaustive overview of all theme features, settings, shortcodes, and custom widgets.

---

## 🚀 Overview
**Drama Mojaz** is a premium WordPress sports news theme designed with high-performance aesthetics, featuring a dark/light mode ready UI, glassmorphism elements, and fully responsive layouts.

### Core Features
- **Modern UI/UX**: Built with Tailwind CSS logic and custom premium styling.
- **Dynamic Homepage**: Fully reorderable sections via the Theme Options.
- **Stories System**: Instagram-style stories integration.
- **Advanced Widgets**: 11+ custom-built sidebar widgets with premium designs.
- **Redux Framework**: Powerful control panel for every aspect of the theme.

---

## 🛠 Home Page Sections & Shortcodes

The theme uses a modular approach for the homepage. You can use the following shortcodes anywhere (Pages, Posts, or Elementor).

| Shortcode | Description |
|-----------|-------------|
| `[dm_homepage]` | Renders **all** enabled sections in the order defined in Theme Options. |
| `[dm_hero]` | Displays the main Hero slider/grid. |
| `[dm_latest_articles]` | The primary "Latest News" section with a large featured post. |
| `[dm_stories]` | Displays the Stories bar (Instagram style). |
| `[dm_videos]` | A dedicated video section with a custom player. |
| `[dm_advanced]` | An "Advanced" section featuring tabbed content for categories. |
| `[dm_compact]` | A grid layout for "More News". |
| `[dm_trending]` | High-impact "Trending Now" section. |
| `[dm_zigzag]` | A creative "Zigzag" alternating layout for featured stories. |
| `[dm_overlay]` | Modern overlay cards for special reports. |
| `[dm_timeline]` | A vertical timeline for the latest chronological events. |

---

## ⚙️ Theme Options (Redux Control Panel)

Accessed via **Admin Dashboard > الإعدادات العامة (Theme Settings)**.

### 1. General Settings
- **Logo & Favicon**: Upload your primary branding assets.
- **Colors**: Control Primary and Secondary brand colors globally.

### 2. Header & Banner
- **Sticky Header**: Toggle fixed navigation.
- **Top Bar**: Show/hide date and custom menus.
- **Search**: Toggle the global search bar.

### 3. Homepage Management
- **Section Order**: Drag-and-drop to reorder all sections listed in the table above.
- **Section Settings**: Individual controls for each section (e.g., categories, post counts).

### 4. Weather Integration
- **OpenWeatherMap**: Enter your API key and default city (Default: Cairo, EG).
- **Units**: Toggle between Metric (°C) and Imperial (°F).

### 5. Widget Controls
- **Global Toggles**: Enable or disable any of the 11 custom widgets with a single click.

### 6. Sidebar & Footer
- **Sidebar Position**: Left or Right alignment.
- **Footer Content**: About text, Copyright info, and secondary Logo.

---

## 📦 Custom Premium Widgets

The theme includes a suite of custom widgets located in `inc/widgets.php`.

| Widget Name | Functionality |
|-------------|---------------|
| **DM: Advertisement Block** | Easy-to-manage sidebar advertisement space. |
| **DM: Trending Posts** | Displays most-commented posts with numerical ranking. |
| **DM: Categories Highlight** | Visual badges for top categories with post counts. |
| **DM: Social Media Hub** | Premium links to FB, Twitter, IG, and TikTok. |
| **DM: WhatsApp CTA** | High-conversion link to join a WhatsApp channel. |
| **DM: Premium Search** | A stylized search bar with suggested tags. |
| **DM: Author Box** | Displays post author details with a premium profile card. |
| **DM: Premium Weather** | Live weather data with glassmorphism backgrounds. |
| **DM: Random Quote** | Sports-themed quotes (Muhammad Ali, Jordan, etc.). |
| **DM: Premium Calendar** | A beautifully customized event calendar. |
| **DM: Premium Newsletter** | Modern subscription form for email marketing. |

---

## 📱 Responsive Design
The theme is built using a "Mobile-First" approach:
- **Desktop**: Full layout with sidebar.
- **Tablet**: Optimized grid structures.
- **Mobile**: Collapsible header, horizontal scrolling for navigation and stories.

---

## 🛠 Technical Details
- **CSS Framework**: Custom CSS with Tailwind utility classes.
- **JS Functions**: `assets/js/main.js` handles all UI interactions.
- **Stories Logic**: `inc/stories.php` manages story data and viewer modals.
- **Helper Functions**: Located in `inc/redux-helpers.php`.

---

© 2024 Drama Mojaz Theme. All Rights Reserved.
