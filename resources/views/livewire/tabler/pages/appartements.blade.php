<div>
    @component('components.tabler.header', ['title' => 'Appartements', 'subtitle' => 'Gestion immobilière'])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAppart" wire:click="create">
            <i class="ti ti-plus"></i> Appartement
        </button>
        <a class="btn btn-outline-primary" href="{{ route('tabler.appartements_pdf') }}" target="_blank">
            <i class="ti ti-file-type-pdf"></i> PDF
        </a>
    @endcomponent

    <div class="row g-2 mb-3">
        <div class="col">
            @include('components.tabler.search', ['placeholder' => 'Rechercher par nom, numéro ou adresse…'])
        </div>
        <div class="col-12 col-sm-auto">
            <select class="form-select" wire:model.live="filtre_statut">
                <option value="">Tous les statuts</option>
                <option value="1">Occupés</option>
                <option value="0">Libres</option>
            </select>
        </div>
    </div>

    <div class="row row-cards">
        @forelse ($appartements as $appartement)
            @if ($appart_id == $appartement->id)
                <div class="col-12" wire:key="appart-edit-{{ $appartement->id }}">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier « {{ $appartement->nom }} »</h3>
                        </div>
                        <form wire:submit="update">
                            <div class="card-body row">
                                @include('_form.appartement_form')
                            </div>
                            <div class="card-footer d-flex gap-2">
                                <button type="button" wire:click="delete" wire:confirm="Supprimer cet appartement ?" class="btn btn-outline-danger me-auto">
                                    <i class="ti ti-trash"></i> Supprimer
                                </button>
                                <button type="button" wire:click="close" class="btn">Annuler</button>
                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-2"></span>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-6 col-xl-4" wire:key="appart-{{ $appartement->id }}">
                    <div class="card h-100">
                        <div class="card-status-top {{ $appartement->statut ? 'bg-green' : 'bg-red' }}"></div>
                        <div class="card-body">
                            <div class="row g-2 align-items-start">
                                <div class="col-auto">
                                    <span class="avatar {{ $appartement->statut ? 'bg-green-lt' : 'bg-red-lt' }}"><i class="ti ti-home"></i></span>
                                </div>
                                <div class="col text-truncate">
                                    <a href="{{ route('tabler.appartement', ['appartement_id' => $appartement->id]) }}" class="fw-bold fs-3 text-reset">{{ $appartement->nom }}</a>
                                    <div class="text-secondary small">
                                        {{ $appartement->batiment->name ?? 'Sans bâtiment' }}
                                        @if ($appartement->numero) · N° {{ $appartement->numero }} @endif
                                        @if ($appartement->niveau) · {{ $appartement->niveau }} @endif
                                    </div>
                                    @if ($appartement->adresse)
                                        <div class="text-secondary small text-truncate">{{ $appartement->adresse }}</div>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-ghost-primary btn-icon" wire:click="edit({{ $appartement->id }})" title="Modifier">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge {{ $appartement->statut ? 'bg-green-lt' : 'bg-red-lt' }}">{{ $appartement->statut ? 'Occupé' : 'Libre' }}</span>
                                @if ($appartement->contrat)
                                    <span class="text-truncate mx-2">{{ \App\Support\Format::person($appartement->contrat->client) }}</span>
                                    <span class="fw-bold text-nowrap">{{ \App\Support\Format::money($appartement->contrat->montant) }}</span>
                                @else
                                    <span class="text-secondary small">Aucun contrat</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            @include('components.tabler.empty', ['icon' => 'ti-home', 'title' => 'Aucun appartement', 'message' => $search || $filtre_statut !== '' ? 'Aucun résultat pour ces critères.' : 'Ajoutez un premier appartement.'])
        @endforelse
    </div>

    @if ($appartements->hasPages())
        <div class="mt-3">{{ $appartements->links() }}</div>
    @endif

    <div class="modal modal-blur fade" id="modalAppart" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form class="modal-content" wire:submit="store_appart">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un appartement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body row">
                    @if (! $appart_id)
                        @include('_form.appartement_form')
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="store_appart" class="spinner-border spinner-border-sm me-2"></span>Ajouter l'appartement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
