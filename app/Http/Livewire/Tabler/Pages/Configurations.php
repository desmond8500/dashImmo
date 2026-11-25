<?php

namespace App\Http\Livewire\Tabler\Pages;

use App\Http\Livewire\Tabler\Concerns\InteractsWithUi;
use App\Models\Settings;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Configurations extends Component
{
    use InteractsWithUi;

    public $value, $key;
    public $selected_id;

    protected function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255', Rule::unique('settings', 'key')->ignore($this->selected_id)],
            'value' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected $validationAttributes = [
        'key' => 'clé',
        'value' => 'valeur',
    ];

    public function render()
    {
        return view('livewire.tabler.pages.configurations', [
            'settings' => Settings::orderBy('key')->get(),
        ])->extends('app.layout')->section('content');
    }

    public function store()
    {
        $this->key = strtolower(trim((string) $this->key));
        $this->validate();
        Settings::create(['key' => $this->key, 'value' => $this->value]);

        $this->cancel();
        $this->notify('Configuration ajoutée.');
    }

    public function edit_setting($setting_id)
    {
        $this->resetValidation();
        $setting = Settings::findOrFail($setting_id);
        $this->selected_id = $setting->id;
        $this->key = $setting->key;
        $this->value = $setting->value;
    }

    public function update_setting()
    {
        $this->key = strtolower(trim((string) $this->key));
        $this->validate();
        Settings::findOrFail($this->selected_id)->update(['key' => $this->key, 'value' => $this->value]);

        $this->cancel();
        $this->notify('Configuration modifiée.');
    }

    public function cancel()
    {
        $this->resetValidation();
        $this->reset('key', 'value', 'selected_id');
    }

    public function init()
    {
        Settings::firstOrCreate(['key' => 'date'], ['value' => 2025]);
        Settings::firstOrCreate(['key' => 'name'], ['value' => 2025]);
        Settings::firstOrCreate(['key' => 'start_date'], ['value' => '15 avril 2025']);

        $this->notify('Configurations par défaut créées (les valeurs existantes sont conservées).');
    }
}
