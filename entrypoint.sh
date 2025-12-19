#!/bin/bash
set -e

# copy .env if missing
if [ ! -f .env ]; then
  cp .env.example .env
  echo ".env file created from .env.example"
fi

# generate app key if missing
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
  php artisan key:generate --force
  echo "APP_KEY generated automatically"
fi

# run migrations if needed (optional)
php artisan migrate --force

exec "$@"
