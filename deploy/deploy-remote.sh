#!/usr/bin/env bash
# Déploiement en releases : extraire une nouvelle release puis basculer le lien.
set -euo pipefail

BASE=/var/www/wr508d
RELEASES="$BASE/releases"
RELEASE_ID="${RELEASE_ID:?RELEASE_ID manquant}"
ARCHIVE="$BASE/symfony-artifact-r1.tar.gz"

mkdir -p "$RELEASES" "$BASE/shared/var/log"

# Repartir d'une release propre pour cet identifiant rend le script rejouable.
rm -rf "$RELEASES/$RELEASE_ID"
mkdir -p "$RELEASES/$RELEASE_ID/var"

tar -xzf "$ARCHIVE" -C "$RELEASES/$RELEASE_ID"
rm -f "$ARCHIVE"

# Les journaux sont partagés entre les releases pour conserver l'historique.
ln -sfn "$BASE/shared/var/log" "$RELEASES/$RELEASE_ID/var/log"

export APP_SECRET="$(sed -n 's/^env\[APP_SECRET\] *= *//p' /etc/php/8.4/fpm/pool.d/wr508d.conf)"

cd "$RELEASES/$RELEASE_ID"
composer install --no-dev --optimize-autoloader --no-interaction --no-progress
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

# Bascule atomique de la release active.
ln -sfn "$RELEASES/$RELEASE_ID" "$BASE/current"

sudo systemctl reload php8.4-fpm

# Élagage : conserver les trois dernières releases, sans toucher à la release active.
CURRENT="$(readlink -f "$BASE/current")"
for dir in $(ls -1dt "$RELEASES"/*/ | tail -n +4); do
  target="$(readlink -f "$dir")"
  if [ "$target" != "$CURRENT" ]; then
    rm -rf "$target"
  fi
done

echo "Release $RELEASE_ID en service"
