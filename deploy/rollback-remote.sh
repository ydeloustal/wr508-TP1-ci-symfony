#!/usr/bin/env bash
# Retour à la release précédente : repointer le lien current.
set -euo pipefail

BASE=/var/www/wr508d
RELEASES="$BASE/releases"

CURRENT="$(readlink -f "$BASE/current")"
PREVIOUS=""
for dir in $(ls -1dt "$RELEASES"/*/); do
  target="$(readlink -f "$dir")"
  if [ "$target" != "$CURRENT" ]; then
    PREVIOUS="$target"
    break
  fi
done

if [ -z "$PREVIOUS" ]; then
  echo "Aucune release précédente à servir"
  exit 1
fi

ln -sfn "$PREVIOUS" "$BASE/current"
sudo systemctl reload php8.4-fpm
echo "Retour à la release $(basename "$PREVIOUS")"
