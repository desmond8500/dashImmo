<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithPagination;
use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Appartement;
use App\Models\Compteur;
use Livewire\Attributes\Url;
use Livewire\Component;

class Compteurs extends Component
{
    use InteractsWithPagination, InteractsWithUi;

    public const TYPES = ['EAU', 'Electricité'];

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $filtre_type = '';

    // Clavier numérique sur mobile pour taper un numéro de compteur.
    public $search_type = 'number';

    public $cpt_type = 'EAU', $cpt_number, $appartement_id;
    public $compteur_id = 0;

    protected function rules(): array
    {
        return [
            'cpt_type' => ['required', 'in:'.implode(',', self::TYPES)],
            'cpt_number' => ['required', 'string', 'max:255'],
            'appartement_id' => ['required', 'exists:appartements,id'],
        ];
    }

    protected $validationAttributes = [
        'cpt_type' => 'type de compteur',
        'cpt_number' => 'numéro de compteur',
        'appartement_id' => 'appartement',
    ];

    public function toggle_type()
    {
        $this->search_type = $this->search_type == 'text' ? 'number' : 'text';
    }

    public function updatingFiltreType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = trim($this->search);

        return view('livewire.tabler.pages.compteurs', [
            'compteurs' => Compteur::query()
                ->with('appartement')
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->where('reference', 'like', "%$search%")
                    ->orWhereHas('appartement', fn ($q) => $q->where('nom', 'like', "%$search%"))))
                ->when($this->filtre_type !== '', fn ($q) => $q->where('type', $this->filtre_type))
                // Tri par nom d'appartement sur l'ensemble des résultats (et non
                // seulement sur la page courante).
                ->orderBy(Appartement::select('nom')->whereColumn('appartements.id', 'compteurs.appartement_id'))
                ->orderBy('type')
                ->paginate(24),
            'apparts' => Appartement::orderBy('nom')->get(['id', 'nom']),
            'types' => self::TYPES,
        ])->extends('app.layout')->section('content');
    }

    public function create()
    {
        $this->close();
    }

    public function store()
    {
        $this->validate();
        Compteur::create([
            'type' => $this->cpt_type,
            'reference' => $this->cpt_number,
            'appartement_id' => $this->appartement_id,
        ]);

        $this->close();
        $this->closeModal('modalCompteur');
        $this->notify('Compteur ajouté.');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $compteur = Compteur::findOrFail($id);
        $this->compteur_id = $compteur->id;
        $this->cpt_type = $compteur->type;
        $this->cpt_number = $compteur->reference;
        $this->appartement_id = $compteur->appartement_id;
    }

    public function update()
    {
        $this->validate();
        Compteur::findOrFail($this->compteur_id)->update([
            'type' => $this->cpt_type,
            'reference' => $this->cpt_number,
            'appartement_id' => $this->appartement_id,
        ]);

        $this->close();
        $this->notify('Compteur modifié.');
    }

    public function delete()
    {
        Compteur::find($this->compteur_id)?->delete();

        $this->close();
        $this->notify('Compteur supprimé.', 'warning');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('compteur_id', 'cpt_number', 'cpt_type', 'appartement_id');
    }
}
