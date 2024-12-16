# Utilizar una imagen base de PHP
FROM php:8.2-apache

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Instalar dependencias de Composer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmariadb-dev \
    && docker-php-ext-install pdo pdo_mysql


# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ejecutar Composer para instalar las dependencias
RUN composer install

# Exponer el puerto 80
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
