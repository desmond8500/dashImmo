<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Models\Client as ModelsClient;
use Livewire\Component;

class Client extends Component
{
    public $client_id;

    public function mount($client_id)
    {
        $this->client_id = $client_id;
    }

    public function render()
    {
        return view('livewire.tabler.pages.client', [
            'client' => ModelsClient::with('contrat.appartement.batiment')->findOrFail($this->client_id),
        ])->extends('app.layout')->section('content');
    }
}
