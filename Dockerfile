# Устанавливаем образ с PHP-FPM
FROM php:8.2-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo_mysql

# Копируем проект Laravel в контейнер
COPY . /var/www/html

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем зависимости Laravel
RUN cd /var/www/html && composer install

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN cd /var/www/html && composer dump-autoload --optimize

# Экспортируем порт 9000
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
