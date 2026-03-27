# 1. Basis-Image holen
FROM php:8.4-apache 

# 2. System-Pakete installieren
#    (müssen vor allem anderen da sein)
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    gd \
    exif \
    pdo \
    pdo_pgsql \
    zip


# Composer installieren ✅
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Apache konfigurieren
RUN a2enmod rewrite

# 5. Deine Dateien reinkopieren
COPY . /var/www/html/

# WORKDIR setzen + Flags für Produktion
WORKDIR /var/www/html
# Composer ausführen ✅ ( # 6. Bibliotheken installieren)
RUN composer install --no-dev --optimize-autoloader

# 7. Berechtigungen setzen
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/
RUN find /var/www/html/ -type f -exec chmod 644 {} \;
