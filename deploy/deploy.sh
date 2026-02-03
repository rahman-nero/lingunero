#!/bin/bash

set -e

# Загрузить последнюю версию приложения
git pull origin main

# Stopping containers
make down

# Docker building (with cache)
make build-cache

# Starting containers
make up

# Установить зависимости Composer
make composer-prod-install

# Вход в режима обслуживания
make laravel-down

# Запустить миграцию базы данных
make migrate

# Линк storage папки в public
make storage-link

# Кэширование конфигов
make optimize

# Билд фронтенда
make build-production

# Сброс прав
make chown

# Выход из режима обслуживания
make laravel-up

echo "Deployment finished!"
