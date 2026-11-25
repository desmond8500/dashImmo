<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => 'Clients', 'subtitle' => 'Locataires'])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#immoClient" wire:click="create">
            <i class="ti ti-plus"></i> Client
        </button>
        <a class="btn btn-outline-primary" href="{{ route('tabler.clients_pdf') }}" target="_blank">
            <i class="ti ti-file-type-pdf"></i> PDF
        </a>
    @endcomponent

    <div class="row g-2 mb-3">
        <div class="col">
            @include('components.tabler.search', ['placeholder' => 'Rechercher par prénom, nom ou numéro d\'identité…'])
        </div>
        <div class="col-12 col-sm-auto">
            <select class="form-select" wire:model.live="filtre_statut">
                <option value="">Tous les clients</option>
                <option value="1">Résidents</option>
                <option value="0">Partis</option>
            </select>
        </div>
    </div>

    <div class="row row-cards">
        @forelse ($clients as $client)
            @if ($client_id == $client->id)
                <div class="col-md-12 col-xl-8" wire:key="client-edit-{{ $client->id }}">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Modifier {{ $F::person($client) }}</h3></div>
                        <form wire:submit="update">
                            <div class="card-body row">
                                @include('_form.client_form')
                            </div>
                            <div class="card-footer d-flex gap-2">
                                <button type="button" wire:click="delete" wire:confirm="Supprimer ce client ?" class="btn btn-outline-danger me-auto">
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
                <div class="col-md-6 col-xl-4" wire:key="client-{{ $client->id }}">
                    <div class="card h-100">
                        <div class="card-status-top {{ $client->statut ? 'bg-green' : 'bg-red' }}"></div>
                        <div class="card-body">
                            <div class="row g-2 align-items-start">
                                <div class="col-auto">
                                    <span class="avatar {{ $client->genre == 'femme' ? 'bg-pink-lt' : 'bg-blue-lt' }}">
                                        {{ mb_strtoupper(mb_substr((string) $client->prenom, 0, 1).mb_substr((string) $client->nom, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="col text-truncate">
                                    <a href="{{ route('tabler.client', ['client_id' => $client->id]) }}" class="fw-bold text-reset">{{ $F::person($client) }}</a>
                                    <div class="text-secondary small">
                                        {{ $client->genre == 'femme' ? 'Femme' : 'Homme' }} ·
                                        <span class="{{ $client->statut ? 'text-green' : 'text-red' }}">{{ $client->statut ? 'Résident' : 'Parti' }}</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-ghost-primary btn-icon" wire:click="edit({{ $client->id }})" title="Modifier">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="small mt-2">
                                <div><span class="text-secondary">Pièce d'identité :</span> {{ $client->ci ?: '—' }}</div>
                                <div><span class="text-secondary">Délivrance :</span> {{ $client->delivre ?: '—' }}</div>
                            </div>
                        </div>
                        <div class="card-footer py-2 d-flex justify-content-between align-items-center">
                            @if ($client->contrat)
                                <span class="text-truncate me-2"><i class="ti ti-home text-secondary"></i> {{ $client->contrat->appartement->nom ?? '—' }}</span>
                                <span class="fw-bold text-nowrap">{{ $F::money($client->contrat->montant) }}</span>
                            @else
                                <span class="text-secondary small">Aucun contrat</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @empty
            @include('components.tabler.empty', ['icon' => 'ti-users', 'title' => 'Aucun client', 'message' => $search || $filtre_statut !== '' ? 'Aucun résultat pour ces critères.' : 'Ajoutez un premier client.'])
        @endforelse
    </div>

    @if ($clients->hasPages())
        <div class="mt-3">{{ $clients->links() }}</div>
    @endif

    <div class="modal modal-blur fade" id="immoClient" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form class="modal-content" wire:submit="store">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body row">
                    @if (! $client_id)
                        @include('_form.client_form')
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></span>Ajouter le client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
