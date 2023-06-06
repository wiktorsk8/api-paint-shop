FROM mariadb:latest





## Use the official PHP image with FPM as the base
#FROM php:8.1-fpm
#
## Set the working directory inside the container
#WORKDIR /var/www
#
## Update package lists and install required dependencies
#RUN apt-get update -y && apt-get install -y \
#    nodejs \
#    npm \
#    curl \
#    zip \
#    unzip \
#    && docker-php-ext-install pdo pdo_mysql
#
## Copy application files
#COPY . .
#
## Install Composer
#COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
#
## Install a specific version of Node.js
#RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
## Install project dependencies
#RUN composer install --no-interaction --no-progress
#
## Install npm packages and build assets
#
## Create a symbolic link for storage directory
#RUN cd public && ln -sf ../storage/app/public/ storage
#
## Set environment variable
#ENV PORT=9000
#
## Set the entrypoint script
#ENTRYPOINT ["docker/entrypoint.sh"]
