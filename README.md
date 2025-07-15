# FoodBoard App

Mini-app Laravel + Vue 3 + Vuetify pour gérer des recettes.

## 🛠️ Prérequis
- PHP 8+
- Composer
- Node.js (npm)
- Base MySQL/MariaDB

## 📥 Installation
```bash
git clone <ton_repo>
cd project-folder
composer install
npm install
cp .env.example .env
php artisan key:generate
# Config DB dans .env
php artisan migrate
npm run dev    # ou npm run build pour prod
php artisan serve