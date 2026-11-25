<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => 'Factures', 'subtitle' => 'Factures des compteurs'])
    @endcomponent

    <div class="row row-cards">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        @include('components.tabler.search', ['placeholder' => 'Rechercher par numéro, compteur ou appartement…'])
                    </div>
                </div>

                @if ($facture_id)
                    <div class="card-body border-bottom bg-light">
                        <h3 class="card-title mb-3">Modifier la facture</h3>
                        <form wire:submit="update_facture" class="row">
                            @include('_form.facture_form')
                            <div class="col-12 d-flex gap-2">
                                <button type="button" wire:click="delete_facture" wire:confirm="Supprimer cette facture ?" class="btn btn-outline-danger me-auto">
                                    <i class="ti ti-trash"></i> Supprimer
                                </button>
                                <button type="button" wire:click="reinitialiser" class="btn">Annuler</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="facture,update_facture">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Appartement</th>
                                <th>Compteur</th>
                                <th>Date</th>
                                <th>Numéro</th>
                                <th class="text-end">Montant</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($factures as $item)
                                <tr wire:key="facture-{{ $item->id }}" @class(['table-active' => $facture_id == $item->id])>
                                    <td>{{ $item->compteur->appartement->nom ?? '—' }}</td>
                                    <td class="text-secondary">{{ $item->compteur->type ?? '' }} {{ $item->compteur->reference ?? '' }}</td>
                                    <td class="text-nowrap">{{ $F::date($item->date) }}</td>
                                    <td>
                                        @if ($item->facture)
                                            <a href="{{ asset('storage/'.$item->facture) }}" target="_blank" rel="noopener">
                                                <i class="ti ti-paperclip"></i> {{ $item->numero ?: 'Fichier' }}
                                            </a>
                                        @else
                                            {{ $item->numero ?: '—' }}
                                        @endif
                                    </td>
                                    <td class="text-end text-nowrap fw-bold">{{ $F::money($item->montant) }}</td>
                                    <td>
                                        <button class="btn btn-ghost-primary btn-icon" wire:click="edit_facture({{ $item->id }})" title="Modifier">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-secondary py-5">
                                        {{ $search ? 'Aucune facture ne correspond à la recherche.' : 'Aucune facture enregistrée.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($factures->hasPages())
                    <div class="card-footer">{{ $factures->links() }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ajouter une facture</h3>
                </div>
                @if (! $facture_id)
                    <form wire:submit="store_facture">
                        <div class="card-body row">
                            @include('_form.facture_form')
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" class="btn" wire:click="reinitialiser">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="facture,store_facture">
                                <span wire:loading wire:target="store_facture" class="spinner-border spinner-border-sm me-2"></span>Enregistrer
                            </button>
                        </div>
                    </form>
                @else
                    <div class="card-body text-secondary">Terminez la modification en cours pour ajouter une facture.</div>
                @endif
            </div>
        </div>
    </div>
</div>
