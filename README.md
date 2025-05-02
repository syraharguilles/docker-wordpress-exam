# **ProEvent WordPress Theme & Blocks**

A modern WordPress project using Tailwind CSS v4, custom Gutenberg blocks, and dynamic event content powered by CPTs.

## **Features**
- Tailwind CSS v4 with dark mode support
- Gutenberg Blocks:
  - Hero with CTA block (dynamic image, heading, and button)
  - Event Grid block (custom query for event CPT)
- Custom Post Type: `event`
- Custom Taxonomy: `event-category`
- Custom meta fields: date, time, location, registration link
- Admin Settings page: company logo, brand color, social links
- SEO-friendly slugs: `/events`, `/event-category/...`
- WebP + lazy loading support for images
- Mobile-first responsive design

## **Requirements**
- PHP 8.0+
- Node.js 20+
- Composer
- WordPress (local or Docker)
- MySQL/MariaDB
- PHPMyAdmin

## **Project Structure**
```text
wp-content/
├── themes/
│ └── proevent/
│ ├── assets/ # Tailwind CSS + JS
│ ├── blocks/
│ │ └── hero-cta/ # Gutenberg block (Hero)
│ ├── inc/ # Custom PHP (API, helpers)
│ ├── templates/ # Layout templates
│ ├── front-page.php # Event archive
│ ├── single-event.php # Single event layout
│ ├── functions.php # Theme setup, CPTs, meta, blocks
│ └── style.css
├── plugins/
│ └── event-grid-block/
│ ├── src/
│ ├── assets/
│ ├── build/
│ ├── block.json
│ ├── event-grid.php
│ └── php/
│ └── render.php
```

## **Setup Instructions**
### 1. Clone & Start Docker WordPress
```bash
clone https://github.com/syraharguilles/docker-wordpress-exam.git

# Start WordPress + DB
docker compose up -d
```
### 2. Install Dependencies
From the theme directory:
```bash
cd wp-content/themes/proevent
npm install
composer install
```

# Build Tailwind + JS for theme
```bash
npm run build:theme
```

# Build Gutenberg blocks (hero CTA)
```bash
npm run build:hero
```

# Watch for changes
```bash
npm run watch:all
```
## **Gutenberg Blocks**
- Hero CTA Block (in theme)
 - JSX source: blocks/hero-cta/src/
 - PHP render: blocks/hero-cta/render.php
 - Registered via block.json
 - Built using @wordpress/scripts

## **Event Grid Block (plugin)**
 - Plugin: plugins/event-grid-block
 - Accepts props (limit, category, order, etc.)
 - Built using @wordpress/scripts

## **Architectural Notes**
 - Vite used for bundling theme assets
 - @wordpress/scripts used for block development
 - Tailwind CSS is configured through PostCSS
 - Block JS uses React + WordPress block APIs
 - functions.php handles:
    - CPT and taxonomy registration
    - Block registration
    - Settings page setup