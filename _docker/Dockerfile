FROM php:7.3-fpm

# dockerize (опционально)
ENV DOCKERIZE_VERSION=v0.6.1
RUN curl -sL https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    | tar -xz -C /usr/local/bin

# UID/GID для пользователя внутри контейнера
ARG USER_UID=1000
ARG USER_GID=1000

# Системные зависимости
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Пользователь
RUN groupadd -g ${USER_GID} www && \
    useradd -u ${USER_UID} -ms /bin/bash -g www www

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer --version=2.2.18

WORKDIR /var/www/html

# Кешируем зависимости
COPY --chown=www:www composer.* ./
RUN composer install --no-interaction --no-scripts --no-autoloader --no-ansi --no-progress

# Копируем проект
COPY --chown=www:www . .

# Права на runtime-папки (делаем как root!)
RUN chmod -R 775 storage bootstrap/cache

# Оптимизируем автолоадер
RUN composer dump-autoload --optimize

# Git safe dir (root)
RUN git config --global --add safe.directory /var/www/html

# Дальше работаем под непривилегированным пользователем
USER www

# Без route:cache — чтобы не падать на Closure-маршрутах
RUN test -f .env || (test -f .env.example && cp .env.example .env) \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan view:cache

CMD ["php-fpm", "-F"]
