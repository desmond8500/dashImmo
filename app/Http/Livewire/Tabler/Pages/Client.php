<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Models\Appartement;
use App\Models\Client as ModelsClient;
use Livewire\Component;

class Client extends Component
{
    public $client_id;
    public $client;

    public function mount($client_id)
    {
        $this->client_id = $client_id;
        $this->getClient();
    }

    public function render()
    {
        return view('livewire.tabler.pages.client',[
            'client' => $this->client,
            'apparts' => Appartement::all(),
        ])->extends('app.layout')->section('content');
    }

    public function getClient()
    {
        $this->client = ModelsClient::find($this->client_id);
    }



}
