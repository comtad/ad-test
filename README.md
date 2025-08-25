# Быстрый старт

## Требования
- Docker + Docker Compose v2
- Поддержка Makefile для удобства

## Запуск

```bash
# 1. Собираем контейнеры
make build

# 2. Поднимаем проект в фоне
make up

# 3. Заходим внутрь контейнера app
make shell

# 4. Выполняем внутри контейнера
composer install
cp -f .env.example .env
php artisan key:generate
php artisan migrate

# 5. Тестовый контент если будет желание
php artisan db:seed
