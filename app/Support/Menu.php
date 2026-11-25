<?php

namespace App\Support;

/**
 * Navigation partagée entre la navbar (app.layout) et la sidebar (app.layout-h).
 * Avant la mise en place des permissions, chaque entrée est visible par tout
 * utilisateur connecté.
 *
 * `active` liste les routes (motifs acceptés par request()->routeIs) pour
 * lesquelles l'entrée est mise en surbrillance, pages de détail comprises.
 */
class Menu
{
    public static function items(): array
    {
        return [
            (object) ['name' => 'Bâtiments', 'icon' => 'ti-building', 'route' => 'tabler.batiments', 'active' => ['tabler.batiments']],
            (object) ['name' => 'Clients', 'icon' => 'ti-users', 'route' => 'tabler.clients', 'active' => ['tabler.clients', 'tabler.client']],
            (object) ['name' => 'Appartements', 'icon' => 'ti-home', 'route' => 'tabler.appartements', 'active' => ['tabler.appartements', 'tabler.appartement']],
            (object) ['name' => 'Compteurs', 'icon' => 'ti-gauge', 'route' => 'tabler.compteurs', 'active' => ['tabler.compteurs']],
            (object) ['name' => 'Factures', 'icon' => 'ti-file-invoice', 'route' => 'tabler.factures', 'active' => ['tabler.factures']],
            (object) ['name' => 'Contrats', 'icon' => 'ti-file-text', 'route' => 'tabler.contrats', 'active' => ['tabler.contrats', 'tabler.contrat']],
            (object) ['name' => 'Configurations', 'icon' => 'ti-settings', 'route' => 'tabler.configurations', 'active' => ['tabler.configurations']],
        ];
    }

    public static function isActive(object $menu): bool
    {
        return request()->routeIs(...($menu->active ?? [$menu->route]));
    }
}
