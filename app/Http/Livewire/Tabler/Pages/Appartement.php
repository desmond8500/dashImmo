<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Models\Appartement as ModelsAppartement;
use Livewire\Component;

class Appartement extends Component
{
    public $appartement_id;

    public function mount($appartement_id)
    {
        $this->appartement_id = $appartement_id;
    }

    public function render()
    {
        $appartement = ModelsAppartement::with([
            'batiment',
            'contrat.client',
            'compteurs',
        ])->findOrFail($this->appartement_id);

        return view('livewire.tabler.pages.appartement', [
            'appartement' => $appartement,
            // Requête à part plutôt qu'un eager loading limité (qui utiliserait
            // ROW_NUMBER(), à éviter sur l'hébergement MariaDB visé).
            'factures' => $appartement->factures()->with('compteur')->orderByDesc('date')->limit(10)->get(),
        ])->extends('app.layout')->section('content');
    }
}
