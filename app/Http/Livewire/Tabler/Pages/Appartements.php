<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithPagination;
use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Appartement as ModelsAppartement;
use App\Models\Batiment;
use Livewire\Attributes\Url;
use Livewire\Component;

class Appartements extends Component
{
    use InteractsWithPagination, InteractsWithUi;

    public const NIVEAUX = ['Sous sol', 'RDC', 'Mezzanine', 'Etage 1', 'Etage 2', 'Etage 3', 'Etage 4'];

    #[Url(except: '')]
    public $search = '';

    /** '' = tous, '1' = occupés, '0' = libres */
    #[Url(except: '')]
    public $filtre_statut = '';

    public $appart_id = 0;
    public $batiment_id;
    public $nom, $numero, $niveau = 'RDC', $adresse, $statut = 0;

    protected function rules(): array
    {
        return [
            'batiment_id' => ['required', 'exists:batiments,id'],
            'nom' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:255'],
            'niveau' => ['nullable', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'statut' => ['boolean'],
        ];
    }

    protected $validationAttributes = [
        'batiment_id' => 'bâtiment',
    ];

    public function updatingFiltreStatut()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = trim($this->search);

        return view('livewire.tabler.pages.appartements', [
            'appartements' => ModelsAppartement::query()
                ->with(['batiment', 'contrat.client'])
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->where('nom', 'like', "%$search%")
                    ->orWhere('numero', 'like', "%$search%")
                    ->orWhere('adresse', 'like', "%$search%")))
                ->when($this->filtre_statut !== '', fn ($q) => $q->where('statut', (bool) $this->filtre_statut))
                ->orderBy('batiment_id')
                ->orderBy('nom')
                ->paginate(12),
            'batiments' => Batiment::orderBy('name')->get(['id', 'name']),
            'niveaux' => self::NIVEAUX,
        ])->extends('app.layout')->section('content');
    }

    public function create()
    {
        $this->close();
    }

    public function store_appart()
    {
        $data = $this->validate();
        ModelsAppartement::create($data);

        $this->close();
        $this->closeModal('modalAppart');
        $this->notify('Appartement ajouté.');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $appart = ModelsAppartement::findOrFail($id);
        $this->appart_id = $appart->id;
        $this->nom = $appart->nom;
        $this->batiment_id = $appart->batiment_id;
        $this->numero = $appart->numero;
        $this->niveau = $appart->niveau;
        $this->adresse = $appart->adresse;
        $this->statut = (int) $appart->statut;
    }

    public function update()
    {
        $data = $this->validate();
        ModelsAppartement::findOrFail($this->appart_id)->update($data);

        $this->close();
        $this->notify('Appartement modifié.');
    }

    public function delete()
    {
        ModelsAppartement::find($this->appart_id)?->delete();

        $this->close();
        $this->notify('Appartement supprimé.', 'warning');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('appart_id', 'batiment_id', 'nom', 'numero', 'niveau', 'adresse', 'statut');
    }
}
