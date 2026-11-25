<?php

namespace App\Http\Livewire\Tabler;

use App\Models\Appartement;
use App\Models\Batiment;
use App\Models\Client;
use App\Models\Compteur;
use App\Models\Contrat;
use App\Models\Facture;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $appartements = Appartement::count();
        $occupes = Appartement::where('statut', true)->count();

        return view('livewire.tabler.index', [
            'cards' => $this->getResume(),
            'stats' => (object) [
                'appartements' => $appartements,
                'occupes' => $occupes,
                'libres' => $appartements - $occupes,
                'taux' => $appartements ? round($occupes * 100 / $appartements) : 0,
                'loyers' => (float) Contrat::whereHas('client', fn ($q) => $q->where('statut', true))->sum('montant'),
            ],
            'libres' => Appartement::with('batiment')->where('statut', false)->orderBy('nom')->limit(8)->get(),
            'factures' => Facture::with('compteur.appartement')->latest('id')->limit(5)->get(),
        ])->extends('app.layout')->section('content');
    }

    public function getResume(): array
    {
        return [
            (object) ['name' => 'Bâtiments', 'route' => 'batiments', 'icon' => 'ti-building', 'color' => 'bg-blue', 'description' => 'Immeubles gérés', 'count' => Batiment::count()],
            (object) ['name' => 'Appartements', 'route' => 'appartements', 'icon' => 'ti-home', 'color' => 'bg-green', 'description' => 'Locaux à louer', 'count' => Appartement::count()],
            (object) ['name' => 'Clients', 'route' => 'clients', 'icon' => 'ti-users', 'color' => 'bg-purple', 'description' => 'Locataires enregistrés', 'count' => Client::count()],
            (object) ['name' => 'Contrats', 'route' => 'contrats', 'icon' => 'ti-file-text', 'color' => 'bg-orange', 'description' => 'Contrats de location', 'count' => Contrat::count()],
            (object) ['name' => 'Compteurs', 'route' => 'compteurs', 'icon' => 'ti-gauge', 'color' => 'bg-cyan', 'description' => 'Eau et électricité', 'count' => Compteur::count()],
            (object) ['name' => 'Factures', 'route' => 'factures', 'icon' => 'ti-file-invoice', 'color' => 'bg-red', 'description' => 'Factures des compteurs', 'count' => Facture::count()],
        ];
    }
}
