# -----------------------------------------------------
# ETAPA 1: Dependencias de PHP (Laravel) - SOLO Composer
# -----------------------------------------------------
FROM composer:2.7 as vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts


# ---
# -----------------------------------------------------
# ETAPA 2: Dependencias de Node.js (Vite/Frontend)
# *** Cambio clave aquí: Copiamos los archivos esenciales antes de 'npm install' ***
# -----------------------------------------------------
FROM node:20 as node

WORKDIR /app

# 1. Copiamos solo los archivos de configuración de Node.js
COPY package.json package-lock.json vite.config.js ./

# 2. Copiamos explícitamente la carpeta 'resources' antes de instalar.
# Copiar primero la carpeta 'resources' y luego 'npm install' asegura que la caché
# de 'npm install' solo se invalide si cambian las dependencias, no los assets.
COPY resources/ ./resources/

# 3. Instalamos dependencias
RUN npm install --legacy-peer-deps

# 4. Compilamos los assets de frontend
RUN npm run build


# ---
# -----------------------------------------------------
# ETAPA 3: Imagen Final del Servicio Web (Servidor PHP FPM)
# -----------------------------------------------------
FROM php:8.3-fpm-alpine

# Instala extensiones de PHP necesarias
RUN apk add --no-cache \
    mysql-client \
    git \
    supervisor \
    nginx

RUN docker-php-ext-install pdo_mysql opcache

WORKDIR /var/www/html

# Copia los archivos del proyecto (excepto dependencias)
COPY . .

# Copia las dependencias de Composer desde la etapa 'vendor'
COPY --from=vendor /app/vendor /var/www/html/vendor

# Desde la etapa 'node', copia los assets compilados por Vite (la carpeta 'build') a 'public'
# Esto asume que 'npm run build' crea la carpeta 'public/build'
COPY --from=node /app/public/build /var/www/html/public/build

# Permisos para el usuario web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Comando de inicio: Lo dejo vacío, asumo que usarás un archivo de configuración separado
# para un contenedor Nginx/Caddy/Apache para servir el sitio.

# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]