FROM php:8.3-fpm-alpine

ARG USER_ID=1000
ARG GROUP_ID=1000

# Installation des dépendances système + extensions PHP
RUN apk add --no-cache \
    bash \
    git \
    zip \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libpq-dev \
    shadow \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        intl \
        zip \
        opcache

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Création d'un utilisateur non-root avec UID/GID dynamiques
RUN addgroup -g ${GROUP_ID} php || true \
    && adduser -D -u ${USER_ID} -G php php

# Basculer sur l'utilisateur app
USER php
WORKDIR /var/www
