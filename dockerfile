# Étape 1 : base PHP
FROM php:8.2-fpm

# Définir le dossier de travail
WORKDIR /var/www

# Installer dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    npm \
    nodejs \
    && docker-php-ext-install pdo mbstring zip exif pcntl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier tout le projet
COPY . .

# Installer les dépendances PHP Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ----------------------
# Étape 2 : build du frontend (dans ./foodboard-front)
# ----------------------
WORKDIR /var/www/foodboard-front

RUN npm install && npm run build

# Copier le build frontend dans le dossier public/ de Laravel
RUN cp -r dist/* ../public/

# ----------------------
# Étape 3 : revenir dans Laravel pour démarrer l'app
# ----------------------
WORKDIR /var/www

# Fixer les permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Exposer le port
EXPOSE 8000

# Commande de démarrage (Render détecte ce port)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]