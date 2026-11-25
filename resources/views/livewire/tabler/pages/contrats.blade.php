<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => 'Contrats', 'subtitle' => 'Contrats de location'])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalContrat" wire:click="create">
            <i class="ti ti-plus"></i> Contrat
        </button>
        <a class="btn btn-outline-primary" href="{{ route('tabler.all_contrat_pdf') }}" target="_blank">
            <i class="ti ti-file-type-pdf"></i> Tous les contrats
        </a>
    @endcomponent

    <div class="mb-3">
        @include('components.tabler.search', ['placeholder' => 'Rechercher un contrat par client ou appartement…'])
    </div>

    <div class="row row-cards">
        @forelse ($contrats as $contrat)
            @if ($contrat_id == $contrat->id)
                <div class="col-12" wire:key="contrat-edit-{{ $contrat->id }}">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Modifier le contrat de {{ $F::person($contrat->client) }}</h3></div>
                        <form wire:submit="update_contract">
                            <div class="card-body row">
                                @include('_form.contrat_form')
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button type="button" class="btn" wire:click="close">Annuler</button>
                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading wire:target="update_contract" class="spinner-border spinner-border-sm me-2"></span>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-6 col-xl-4" wire:key="contrat-{{ $contrat->id }}">
                    <div class="card h-100">
                        @unless ($contrat->client?->statut)
                            <div class="card-status-top bg-red" title="Client parti"></div>
                        @endunless
                        <div class="card-header">
                            <div class="text-truncate">
                                <a href="{{ route('tabler.contrat', ['contrat_id' => $contrat->id]) }}" class="card-title text-reset {{ $contrat->client?->statut ? '' : 'text-red' }}">
                                    {{ $F::person($contrat->client) }}
                                </a>
                                <div class="card-subtitle">{{ $types[$contrat->type] ?? 'Type non précisé' }}</div>
                            </div>
                            <div class="card-actions btn-list flex-nowrap">
                                <button class="btn btn-ghost-primary btn-icon" wire:click="edit_contract({{ $contrat->id }})" title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <a class="btn btn-ghost-primary btn-icon" href="{{ route('tabler.contrat_pdf', ['contrat_id' => $contrat->id]) }}" target="_blank" title="Contrat PDF">
                                    <i class="ti ti-file-type-pdf"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="text-truncate me-2">
                                    <div class="fw-bold text-primary fs-3">{{ $contrat->appartement->nom ?? '—' }}</div>
                                    <div class="text-secondary small text-truncate">{{ $contrat->appartement->adresse ?? '' }}</div>
                                </div>
                                <div class="fs-3 fw-bold text-nowrap">{{ $F::money($contrat->montant) }}</div>
                            </div>
                            @if ($contrat->debut || $contrat->fin)
                                <div class="small text-secondary mt-2"><i class="ti ti-calendar"></i> {{ $F::date($contrat->debut) }} → {{ $F::date($contrat->fin) }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @empty
            @include('components.tabler.empty', ['icon' => 'ti-file-text', 'title' => 'Aucun contrat', 'message' => $search ? 'Aucun contrat ne correspond à la recherche.' : 'Ajoutez un premier contrat.'])
        @endforelse
    </div>

    @if ($contrats->hasPages())
        <div class="mt-3">{{ $contrats->links() }}</div>
    @endif

    <div class="modal modal-blur fade" id="modalContrat" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" wire:submit="add_contract">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un contrat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body row">
                    @if (! $contrat_id)
                        @include('_form.contrat_form')
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="add_contract" class="spinner-border spinner-border-sm me-2"></span>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
