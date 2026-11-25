<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithPagination;
use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\Contrat;
use Livewire\Attributes\Url;
use Livewire\Component;

class Contrats extends Component
{
    use InteractsWithPagination, InteractsWithUi;

    public const TYPES = ['habitation' => 'Habitation', 'bureau' => 'Bureau'];

    #[Url(except: '')]
    public $search = '';

    public $client_id, $appartement_id, $montant, $date, $type = 'habitation', $sign1 = 0, $sign2 = 0;
    public $debut, $fin;
    public $contrat_id;

    protected function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'appartement_id' => ['required', 'exists:appartements,id'],
            'montant' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:'.implode(',', array_keys(self::TYPES))],
            'date' => ['nullable', 'date'],
            'debut' => ['nullable', 'date'],
            'fin' => array_filter(['nullable', 'date', $this->debut ? 'after_or_equal:debut' : null]),
            'sign1' => ['boolean'],
            'sign2' => ['boolean'],
        ];
    }

    protected $validationAttributes = [
        'client_id' => 'client',
        'appartement_id' => 'appartement',
        'debut' => 'date de début',
        'fin' => 'date de fin',
        'sign1' => 'signature',
    ];

    public function render()
    {
        $search = trim($this->search);

        return view('livewire.tabler.pages.contrats', [
            'contrats' => Contrat::query()
                ->with(['client', 'appartement'])
                ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                    ->whereHas('client', fn ($q) => $q->where('nom', 'like', "%$search%")->orWhere('prenom', 'like', "%$search%"))
                    ->orWhereHas('appartement', fn ($q) => $q->where('nom', 'like', "%$search%"))))
                ->orderBy(Client::select('nom')->whereColumn('clients.id', 'contrats.client_id'))
                ->paginate(12),
            'clients' => Client::orderBy('nom')->orderBy('prenom')->get(['id', 'prenom', 'nom']),
            'appartements' => Appartement::orderBy('nom')->get(['id', 'nom']),
            'types' => self::TYPES,
        ])->extends('app.layout')->section('content');
    }

    public function create()
    {
        $this->close();
    }

    public function add_contract()
    {
        Contrat::create($this->payload());

        $this->close();
        $this->closeModal('modalContrat');
        $this->notify('Contrat ajouté.');
    }

    public function edit_contract($contrat_id)
    {
        $this->resetValidation();
        $contrat = Contrat::findOrFail($contrat_id);
        $this->contrat_id = $contrat->id;

        $this->client_id = $contrat->client_id;
        $this->appartement_id = $contrat->appartement_id;
        $this->montant = $contrat->montant;
        $this->date = $contrat->date;
        $this->debut = $contrat->debut;
        $this->fin = $contrat->fin;
        $this->type = $contrat->type ?: 'habitation';
        $this->sign1 = (int) $contrat->sign1;
        $this->sign2 = (int) $contrat->sign2;
    }

    public function update_contract()
    {
        Contrat::findOrFail($this->contrat_id)->update($this->payload());

        $this->close();
        $this->notify('Contrat modifié.');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('contrat_id', 'client_id', 'appartement_id', 'montant', 'date', 'debut', 'fin', 'type', 'sign1', 'sign2');
    }

    private function payload(): array
    {
        $data = $this->validate();

        // Les dates restent des chaînes "Y-m-d" (cf. App\Models\Contrat) ; un
        // champ vidé devient null plutôt qu'une chaîne vide.
        foreach (['date', 'debut', 'fin'] as $key) {
            $data[$key] = $data[$key] ?: null;
        }

        return $data;
    }
}
