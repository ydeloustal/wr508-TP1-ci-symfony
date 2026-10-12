#!/usr/bin/env bash
# Mise en service de l'artefact sur le serveur.
set -euo pipefail

APP_DIR=/var/www/wr508d
ARCHIVE="$APP_DIR/symfony-artifact-r1.tar.gz"

cd "$APP_DIR"

tar -xzf "$ARCHIVE"
rm -f "$ARCHIVE"

export APP_SECRET="$(sed -n 's/^env\[APP_SECRET\] *= *//p' /etc/php/8.4/fpm/pool.d/wr508d.conf)"

composer install --no-dev --optimize-autoloader --no-interaction --no-progress

php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

sudo systemctl reload php8.4-fpm

echo "Mise en service terminée"
