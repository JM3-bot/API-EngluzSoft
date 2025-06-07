# Dockerfile

FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação
COPY . .

# Instala dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Gera chave do Laravel
RUN php artisan config:clear && php artisan key:generate

# Porta que será exposta
EXPOSE 8000

# Comando para iniciar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
