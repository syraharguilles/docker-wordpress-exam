# **ProEvent WordPress Theme & Blocks**

A modern WordPress project using Tailwind CSS v4, custom Gutenberg blocks, and dynamic event content powered by CPTs.

## **Features**
- Tailwind CSS v4 with dark mode support
- Gutenberg Blocks:
  - Hero with CTA block (dynamic image, heading, and button)
  - Event Grid block (custom query for event CPT)
- Custom Post Type: `event`
- Custom Taxonomy: `event-category`
- Custom REST API: `/wp-json/proevent/v1/next?category=[category-name]`
- Custom meta fields: date, time, location, registration link, image, text, cta link
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
│ ├── header.php # Header of the page(s)
│ ├── footer.php # Footer of the page(s)
│ ├── front-page.php # Event archive
│ ├── page.php # All page(s)
│ ├── single-event.php # Single event layout
│ ├── functions.php # Theme setup, CPTs, meta, blocks
│ └── style.css
├── plugins/
│ └── event-grid-block/
│ ├── src/
│ ├── assets/
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

- This starts:
  - wordpress on `http://localhost:8000`
  - phpMyAdmin on `http://localhost:8080`

#### GitHub Actions CI/CD
This project includes a GitHub Actions workflow that:
 - Uploads the repo to a remote server via SCP
 - Runs docker compose up -d on the server to restart the stack

CI Setup Steps
1. Add your private deployment server SSH details to GitHub secrets:
 - SSH_HOST
 - SSH_USER
 - SSH_KEY (private key)
2. On your server:
 - Add your public SSH key to ~/.ssh/authorized_keys
 - Make sure Docker + Docker Compose are installed
3. Push to main and the deployment will trigger automatically.
 - Workflow file: .github/workflows/deploy.yml

### 2. Install Dependencies
####  Install Theme
From the theme directory:
```bash
cd wp-content/themes/proevent
npm install
composer install
```

##### Build Tailwind + JS for theme
```bash
npm run build:theme
```

##### Build Gutenberg blocks (hero CTA)
```bash
npm run build:hero
```

##### Watch for changes
```bash
npm run watch:all
```

####  Install Plugin
From the theme directory:
```bash
cd wp-content/plugins/event-grid-block
npm install
```

##### Build Gutenberg blocks (Event Grid)
```bash
npm run build
```

##### Start Gutenberg blocks (Event Grid)
```bash
npm run start
```

## **Gutenberg Blocks**
- Hero CTA Block (in theme)
 - Block: blocks/hero-cta/
 - JS source: blocks/hero-cta/src/
 - PHP render: blocks/hero-cta/render.php
 - Registered via block.json
 - Accept props (image, header text, button text, link)
 - Built using @wordpress/scripts
 - It is decided to create in theme due these reason:
    - Tightly coupled to theme layout. It should follow what is the theme layout and design  

## **Event Grid Block (plugin)**
 - Plugin: plugins/event-grid-block
 - JS source: plugins/event-grid-block/src/
 - PHP render: plugins/event-grid-block/php/render.php
 - Registered via block.json
 - Accepts props (limit, category, order)
 - Built using @wordpress/scripts
 - It is decided to create in plugin due these reason:
    - It could reused to the other themes

## **Architectural Notes**
 - Vite used for bundling theme assets
   - It is easy to use and faster
 - Chokidar used for bundling theme assets
   -Vite doesnt support watching js, css, php. Opt to use this instead. Fast and efficient.
 - @wordpress/scripts used for block development
   - Default usage for gutenberg block
 - Tailwind CSS is configured through PostCSS
   - Requirements
 - Block JS uses React + WordPress block APIs
   - Requirements 
 - functions.php handles:
    - CPT and taxonomy registration
    - Block registration
    - Settings page setup
