<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithPagination;
use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Compteur;
use App\Models\Facture;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Factures extends Component
{
    use InteractsWithPagination, InteractsWithUi;
    use WithFileUploads;

    #[Url(except: '')]
    public $search = '';

    public $compteur_id, $montant, $date, $facture, $numero;
    public $facture_id = 0;

    // Incrémenté à chaque réinitialisation pour vider le champ fichier.
    public $upload_iteration = 0;

    protected function rules(): array
    {
        return [
            'compteur_id' => ['required', 'exists:compteurs,id'],
            'montant' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'numero' => ['nullable', 'string', 'max:255'],
            'facture' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    protected $validationAttributes = [
        'compteur_id' => 'compteur',
        'numero' => 'numéro de facture',
        'facture' => 'fichier',
    ];

    public function render()
    {
        $search = trim($this->search);

        return view('livewire.tabler.pages.factures', [
            'factures' => Facture::query()
                ->with('compteur.appartement')
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->where('numero', 'like', "%$search%")
                    ->orWhereHas('compteur', fn ($q) => $q
                        ->where('reference', 'like', "%$search%")
                        ->orWhereHas('appartement', fn ($q) => $q->where('nom', 'like', "%$search%")))))
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->paginate(15),
            'compteurs' => Compteur::with('appartement:id,nom')->get(['id', 'appartement_id', 'type', 'reference'])
                ->sortBy(fn ($c) => ($c->appartement->nom ?? '').' '.$c->type),
        ])->extends('app.layout')->section('content');
    }

    public function store_facture()
    {
        $this->validate();

        $facture = Facture::create([
            'compteur_id' => $this->compteur_id,
            'montant' => $this->montant,
            'date' => $this->date,
            'facture' => null,
            'numero' => $this->numero,
        ]);

        if ($this->facture) {
            $facture->facture = $this->storeFile($facture);
            $facture->save();
        }

        $this->reinitialiser();
        $this->notify('Facture enregistrée.');
    }

    public function edit_facture($id)
    {
        $this->resetValidation();
        $facture = Facture::findOrFail($id);
        $this->facture_id = $facture->id;
        $this->compteur_id = $facture->compteur_id;
        $this->montant = $facture->montant;
        $this->date = $facture->date;
        $this->facture = null;
        $this->numero = $facture->numero;
    }

    public function update_facture()
    {
        $this->validate();

        $facture = Facture::findOrFail($this->facture_id);
        $facture->compteur_id = $this->compteur_id;
        $facture->montant = $this->montant;
        $facture->date = $this->date;
        $facture->numero = $this->numero;
        // $facture->facture (le chemin du fichier joint) n'est modifié que
        // si un nouveau fichier est effectivement envoyé : sinon on garde le
        // fichier déjà attaché.
        if ($this->facture) {
            Storage::disk('public')->deleteDirectory("factures/$facture->id");
            $facture->facture = $this->storeFile($facture);
        }

        $facture->save();

        $this->reinitialiser();
        $this->notify('Facture modifiée.');
    }

    public function delete_facture()
    {
        Facture::find($this->facture_id)?->delete();

        $this->reinitialiser();
        $this->notify('Facture supprimée.', 'warning');
    }

    public function reinitialiser()
    {
        $this->resetValidation();
        $this->reset('facture_id', 'compteur_id', 'montant', 'date', 'facture', 'numero');
        $this->upload_iteration++;
    }

    private function storeFile(Facture $facture): string
    {
        $dir = "factures/$facture->id";
        $name = $this->facture->getClientOriginalName();
        $this->facture->storeAs($dir, $name, 'public');

        return "$dir/$name";
    }
}
