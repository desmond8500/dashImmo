# dashImmo

Application de gestion immobilière (bâtiments, appartements, compteurs, factures, contrats de location) — Laravel 13 + Livewire 3.

Reprise et mise à jour de l'ancien dépôt « Building-management » (Laravel 8 / Livewire 2).

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

## Notes de migration

Voir `CLAUDE.md` pour les conventions du projet. Principaux changements par rapport à l'ancien dépôt :

- Laravel 8 → 13, Livewire 2 → 3.
- Suppression du code mort : thème « Material », modèle `Clients` (doublon non routé de `Client`), ancien CRUD InfyOm non routé, packages inutilisés (yajra/datatables, infyomlabs/*, appointer/swaggervel, laravelcollective/html).
- Correction de bugs : import de classe `Eloquent` inexistante sur plusieurs modèles, clé étrangère `batiment_id` jamais réellement contrainte, mise à jour d'une facture qui effaçait le fichier joint sans nouvel upload, recherche de contrat par client provoquant une erreur si aucun client ne correspond, création d'appartement n'enregistrant jamais le bâtiment choisi, fichiers de factures stockés sur le mauvais disque (non accessibles via le lien `public/storage`).
