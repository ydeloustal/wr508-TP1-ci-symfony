# TP CI/CD — Projet Symfony « boutique » (starter)

Ce dossier est votre **projet Symfony** d'entraînement à la construction d'une chaîne
d'intégration continue (CI). Le projet représente, en miniature, une petite
**boutique en ligne** (ACME Store) : des produits, un panier, des remises, un
stock, et la validation des saisies. La séance 02 se déroule **en local** : on démarre
l'environnement, puis on exécute les outils de vérification *à la main*, l'un après
l'autre, pour comprendre ce que chacun fait — avant de les confier à GitHub Actions
(en séance 03).

## Le but de la séance 02

On construit une **suite de vérifications** pour le code, **couche par couche** :

| Vérification | Outil | Ce qu'il vérifie |
|---|---|---|
| 1. le style | **PHP-CS-Fixer** | la mise en forme du code (norme PSR-12 / Symfony) |
| 2. la syntaxe | **`php -l`** | que chaque fichier PHP est syntaxiquement valide |
| 3. l'analyse statique | **PHPStan** | des erreurs dans le code, sans l'exécuter |
| 4. les tests unitaires | **PHPUnit** | que la logique métier fait bien ce qu'on attend |
| 5. les dépendances | **Composer Audit** | des vulnérabilités connues dans les paquets installés |

## Contenu du starter

| Fichier / dossier | Rôle |
|---|---|
| `Dockerfile` + `docker-compose.yml` | l'environnement de travail : PHP 8.4 CLI + Composer |
| `composer.json` / `composer.lock` | les dépendances du projet (et les outils de dev) |
| `src/Entity/` | les objets du domaine : `Product`, `Cart`, `Customer` |
| `src/Service/` | la logique métier : `PriceCalculator` (remises + frais), `InventoryService` (stock), `InputSanitizer` (sécurité des saisies) |
| `src/Controller/StoreController.php` | une route API exemple (`/api/store/sales`) |
| `tests/` | les tests unitaires des trois services |
| `phpstan.neon` | configuration de l'analyse statique (niveau 6) |
| `.php-cs-fixer.dist.php` | configuration du formatage du code |

> ⚠️ Les fichiers `src/` **et** `tests/` contiennent **des erreurs volontaires** : c'est vous qui
> les trouverez et les corrigerez, en utilisant les outils ci-dessus. Les fichiers de test
> portent volontairement des fautes de syntaxe (couche 2), qui se corrigent à la main.



## Démarrer l'environnement

Depuis le dossier du projet (celui qui contient `Dockerfile` et `docker-compose.yml`) :

```bash
docker compose up -d --build     # construit l'image PHP + Composer puis la lance
docker compose exec php bash      # ouvre un terminal DANS le conteneur
```

Vous êtes maintenant « dans » le conteneur, dans `/srv/app` (votre projet y est monté).
Toutes les commandes suivantes s'exécutent **dans ce conteneur**.

Installez une première fois les dépendances (les 2ᵉ/3ᵉ fois seront plus rapides) :

```bash
composer install                  # installe les dépendances épinglées dans composer.lock
```

Prenez le réflexe de vérifier votre utilisateur : `id -u` doit afficher **1000** (le même
UID que votre compte sur la VDI), ce qui évite les problèmes de droits sur les fichiers
partagés.



## Les commandes de la suite (dans l'ordre)

### 1. Le style — PHP-CS-Fixer

```bash
./vendor/bin/php-cs-fixer fix --dry-run --diff     # voir les problèmes SANS corriger
./vendor/bin/php-cs-fixer fix                       # corriger automatiquement
./vendor/bin/php-cs-fixer fix --dry-run --diff      # vérifier que tout est propre
```

### 2. La syntaxe — `php -l`

```bash
find src tests -name "*.php" -exec php -l {} \;
```

(certaines coquilles de syntaxe sont volontaires dans `tests/` : `php -l` vous les montre.)



### 3. L'analyse statique — PHPStan

```bash
./vendor/bin/phpstan analyse
```

PHPStan lit `phpstan.neon`. Corrigez les erreurs signalées dans `src/`.



### 4. Les tests unitaires — PHPUnit

```bash
./vendor/bin/phpunit
```

Des tests échouent : corrigez les trois services (`src/Service/`) jusqu'à ce que
**tous** les tests passent.



### 5. Les dépendances — Composer Audit

```bash
composer audit --format=json --no-interaction
```

Le starter épingle volontairement une **ancienne version** de `twig/twig` : l'audit signale
des vulnérabilités connues. Mettez le paquet à jour :

```bash
composer update twig/twig
```

puis relancez l'audit : plus rien.



## Points de contrôle

- [ ] `docker compose ps` : le conteneur `ci-symfony` est **UP**.
- [ ] `php-cs-fixer fix --dry-run --diff` n'affiche plus aucun `diff`.
- [ ] `php -l` n'affiche plus aucune « syntax error » après vos corrections.
- [ ] `phpstan analyse` ne signale plus d'erreur.
- [ ] `phpunit` affiche **OK (13 tests, …)**.
- [ ] `composer audit` n'affiche plus aucune advisory (après `composer update twig/twig`).



## Pour repartir de zéro

```bash
docker compose down && docker compose up -d --build
```

Le code, lui, reste dans vos fichiers (le conteneur est jetable, pas vos sources).