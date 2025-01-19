# Utiliser l'image officielle PHP avec FPM
FROM php:8.4-fpm

# Mettre à jour les paquets et installer les dépendances nécessaires
RUN apt update && apt install -y \
    git \
    zip \
    unzip \
    curl \
    gnupg2 \
    lsb-release \
    ca-certificates

# Installation de Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt install -y nodejs \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de l'extension PDO MySQL
RUN docker-php-ext-install pdo_mysql

# Installation de Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir la variable d'environnement pour Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
