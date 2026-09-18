# ============================================================================
#  Dockerfile — conteneur « ci-symfony » : PHP + Composer pour le TP CI
# ============================================================================
#  C'est l'environnement où l'on exécute les outils de vérification du CI
#  (PHP-CS-Fixer, php -l, PHPStan, PHPUnit, Composer Audit) avant de les
#  confier à GitHub Actions (séance 3). On part d'une image PHP CLI, à
#  laquelle on ajoute Composer — rien de plus.
# ============================================================================

FROM php:8.4-cli

RUN docker-php-ext-install pdo_mysql \
    && apt-get update \
    && apt-get install -y --no-install-recommends unzip git \
    && rm -rf /var/lib/apt/lists/* \
    && useradd --create-home --uid 1000 mmi

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

USER mmi

WORKDIR /srv/app