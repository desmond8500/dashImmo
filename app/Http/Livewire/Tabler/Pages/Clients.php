<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithPagination;
use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Client;
use Livewire\Attributes\Url;
use Livewire\Component;

class Clients extends Component
{
    use InteractsWithPagination, InteractsWithUi;

    #[Url(except: '')]
    public $search = '';

    /** '' = tous, '1' = résidents, '0' = partis */
    #[Url(except: '')]
    public $filtre_statut = '';

    public $prenom, $nom, $genre = 'homme', $ci, $delivre, $statut = 1;
    public $client_id;

    protected function rules(): array
    {
        return [
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'in:homme,femme'],
            'ci' => ['nullable', 'string', 'max:255'],
            'delivre' => ['nullable', 'string', 'max:255'],
            'statut' => ['boolean'],
        ];
    }

    protected $validationAttributes = [
        'ci' => 'numéro d\'identité',
        'delivre' => 'délivrance',
    ];

    public function updatingFiltreStatut()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = trim($this->search);

        return view('livewire.tabler.pages.clients', [
            'clients' => Client::query()
                ->with('contrat.appartement')
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->where('prenom', 'like', "%$search%")
                    ->orWhere('nom', 'like', "%$search%")
                    ->orWhere('ci', 'like', "%$search%")))
                ->when($this->filtre_statut !== '', fn ($q) => $q->where('statut', (bool) $this->filtre_statut))
                ->orderBy('nom')
                ->orderBy('prenom')
                ->paginate(12),
        ])->extends('app.layout')->section('content');
    }

    public function create()
    {
        $this->close();
    }

    public function store()
    {
        Client::create($this->validate());

        $this->close();
        $this->closeModal('immoClient');
        $this->notify('Client ajouté.');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $client = Client::findOrFail($id);
        $this->client_id = $client->id;
        $this->prenom = $client->prenom;
        $this->nom = $client->nom;
        $this->genre = $client->genre;
        $this->statut = (int) $client->statut;
        $this->ci = $client->ci;
        $this->delivre = $client->delivre;
    }

    public function update()
    {
        Client::findOrFail($this->client_id)->update($this->validate());

        $this->close();
        $this->notify('Client modifié.');
    }

    public function delete()
    {
        Client::find($this->client_id)?->delete();

        $this->close();
        $this->notify('Client supprimé.', 'warning');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('client_id', 'prenom', 'nom', 'genre', 'ci', 'delivre', 'statut');
    }
}
