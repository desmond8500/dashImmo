# dashImmo — consignes

- Reprise de l'ancien dépôt « Building-management » (Laravel 8), migrée vers Laravel 13 + Livewire 3. Application monolithique Blade/Livewire (pas de split API + frontend séparé comme sur les projets Dash4) : « Gestion immobilière » (bâtiments, appartements, compteurs, factures, contrats de location).
- Interface en français, code en anglais. Thème Tabler chargé en CDN (pas de build front : pas de `package.json`/Vite/Mix).
- Authentification volontairement non branchée pour l'instant (`routes/web.php` : route `login` = simple placeholder). À faire plus tard.
- Livewire 3 : les bindings sont `wire:model` (déféré par défaut) sauf les champs de recherche live, en `wire:model.live`.
- Modèles dans `app/Models`, composants Livewire dans `app/Http/Livewire/Tabler` (`Pages/*` = une page par ressource). Navigation partagée (navbar + sidebar) dans `App\Support\Menu`.
- PDF générés via `barryvdh/laravel-dompdf` (`PdfController`) ; le texte des contrats (`resources/views/contrats/contrat_pdf.blade.php` etc.) est le contenu métier réel, à ne pas modifier sans demande explicite.
- Fichiers joints aux factures : disque `public` (`storage/app/public`, lien symbolique `public/storage`), jamais le disque `local` par défaut.
- Hébergement visé : mutualisé type alwaysdata (MariaDB) — pas de worker de queue permanent (`QUEUE_CONNECTION=sync`), pas de fonctionnalité propre à une version récente de MySQL.
- Push direct sur `main`.
