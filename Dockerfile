FROM php:8.2-fpm

# Install system dependencies, PHP extensions, and Node.js (for Vite)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install pdo_mysql gd \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear config and route cache safely
RUN php artisan config:clear \
    && php artisan route:clear

# Install Node dependencies and build Vite assets for production
RUN npm install && npm run build

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Write a clean Nginx configuration template
RUN echo 'server { \
    listen __PORT__; \
    index index.php index.html; \
    root /var/www/html/public; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/sites-available/default

# Expose port 80
EXPOSE 80

# Startup script to handle Render's dynamic $PORT substitution, start Nginx, and run PHP-FPM
CMD sed -i "s/__PORT__/${PORT:-80}/g" /etc/nginx/sites-available/default && service nginx start && php-fpm
