<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Batiment;
use Livewire\Component;

class Batiments extends Component
{
    use InteractsWithUi;

    public $name, $address, $description;
    public $batiment_id;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    protected $validationAttributes = [
        'name' => 'nom',
        'address' => 'adresse',
    ];

    public function render()
    {
        return view('livewire.tabler.pages.batiments', [
            'batiments' => Batiment::query()
                ->with([
                    'appartements' => fn ($q) => $q->orderBy('nom'),
                    'contrats.client',
                ])
                ->orderBy('name')
                ->get(),
        ])->extends('app.layout')->section('content');
    }

    public function store()
    {
        $this->validate();

        Batiment::create([
            'name' => ucfirst($this->name),
            'address' => ucfirst((string) $this->address),
            'description' => ucfirst((string) $this->description),
        ]);

        $this->close();
        $this->closeModal('addBatiment');
        $this->notify('Bâtiment ajouté.');
    }

    public function edit($batiment_id)
    {
        $this->resetValidation();
        $batiment = Batiment::findOrFail($batiment_id);
        $this->batiment_id = $batiment->id;
        $this->name = $batiment->name;
        $this->address = $batiment->address;
        $this->description = $batiment->description;
    }

    public function update()
    {
        $this->validate();

        $batiment = Batiment::findOrFail($this->batiment_id);
        $batiment->name = ucfirst($this->name);
        $batiment->address = ucfirst((string) $this->address);
        $batiment->description = ucfirst((string) $this->description);
        $batiment->save();

        $this->close();
        $this->notify('Bâtiment modifié.');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('batiment_id', 'name', 'address', 'description');
    }
}
