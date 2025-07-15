# Étape 1 : image PHP avec Composer et Node
FROM php:8.2-fpm-alpine
# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    libpng-dev libonig-dev libxml2-dev \
    npm nodejs \
    && docker-php-ext-install pdo mbstring zip exif pcntl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers Laravel
WORKDIR /var/www
COPY . .

# Installer les dépendances PHP et Node + build du front
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Lancer Laravel en mode serveur (sur le port de Render)
CMD php artisan serve --host=0.0.0.0 --port=10000