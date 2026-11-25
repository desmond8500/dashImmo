<div>
    @component('components.tabler.header', ['title' => 'Configurations', 'subtitle' => 'Paramètres utilisés dans les contrats'])
        <button class="btn btn-outline-primary" wire:click="init" title="Crée les clés date, name et start_date si elles manquent">
            <i class="ti ti-wand"></i> Valeurs par défaut
        </button>
    @endcomponent

    <div class="row row-cards">
        <div class="col-lg-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr><th>Clé</th><th>Valeur</th><th class="w-1"></th></tr>
                        </thead>
                        <tbody>
                            @forelse ($settings as $setting)
                                @if ($selected_id == $setting->id)
                                    <tr wire:key="setting-edit-{{ $setting->id }}">
                                        <td colspan="3">
                                            <form wire:submit="update_setting" class="row">
                                                @include('_form.setting_form')
                                                <div class="col-12 d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn" wire:click="cancel">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <tr wire:key="setting-{{ $setting->id }}">
                                        <td class="fw-bold font-monospace">{{ $setting->key }}</td>
                                        <td>{{ $setting->value }}</td>
                                        <td>
                                            <button class="btn btn-ghost-primary btn-icon" wire:click="edit_setting({{ $setting->id }})" title="Modifier"><i class="ti ti-edit"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr><td colspan="3" class="text-center text-secondary py-5">Aucune configuration. Utilisez « Valeurs par défaut » pour créer celles des contrats.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Ajouter une configuration</h3></div>
                @if (! $selected_id)
                    <form wire:submit="store">
                        <div class="card-body row">
                            @include('_form.setting_form')
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                @else
                    <div class="card-body text-secondary">Terminez la modification en cours pour ajouter une configuration.</div>
                @endif
            </div>
        </div>
    </div>
</div>
