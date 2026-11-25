<?php

namespace App\Support;

/**
 * Navigation partagée entre la navbar (app.layout) et la sidebar (app.layout-h).
 * Avant la mise en place des permissions, chaque entrée est visible par tout
 * utilisateur connecté.
 */
class Menu
{
    public static function items(): array
    {
        $circle = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <circle cx="12" cy="12" r="9"></circle> </svg>';

        return [
            (object) ['name' => 'Batiments', 'icon' => $circle, 'route' => 'tabler.batiments'],
            (object) ['name' => 'Clients', 'icon' => $circle, 'route' => 'tabler.clients'],
            (object) ['name' => 'Appartements', 'icon' => $circle, 'route' => 'tabler.appartements'],
            (object) ['name' => 'Compteurs', 'icon' => $circle, 'route' => 'tabler.compteurs'],
            (object) ['name' => 'Factures', 'icon' => $circle, 'route' => 'tabler.factures'],
            (object) ['name' => 'Contrats', 'icon' => $circle, 'route' => 'tabler.contrats'],
            (object) ['name' => 'Configurations', 'icon' => $circle, 'route' => 'tabler.configurations'],
        ];
    }
}
