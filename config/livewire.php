<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | Les composants ont été repris de Livewire 2 et restent dans
    | App\Http\Livewire (le défaut de Livewire 3 est App\Livewire).
    | Sans ce réglage, les références par nom comme
    | @livewire('tabler.navbar') ne sont pas résolues.
    |
    */

    'class_namespace' => 'App\\Http\\Livewire',

    'view_path' => resource_path('views/livewire'),

];
