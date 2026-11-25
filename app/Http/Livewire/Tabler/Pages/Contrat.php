<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Models\Contrat as ModelsContrat;
use Livewire\Component;

class Contrat extends Component
{
    public $contrat_id;

    public function mount($contrat_id)
    {
        $this->contrat_id = $contrat_id;
    }

    public function render()
    {
        return view('livewire.tabler.pages.contrat', [
            'contrat' => ModelsContrat::with(['client', 'appartement.batiment'])->findOrFail($this->contrat_id),
        ])->extends('app.layout')->section('content');
    }
}
