<div>
    @component('components.tabler.header', ['title' => 'Bâtiments', 'subtitle' => 'Liste des bâtiments'])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBatiment" wire:click="close">
            <i class="ti ti-plus"></i> Bâtiment
        </button>
    @endcomponent

    <div class="row row-cards">
        @forelse ($batiments as $batiment)
            <div class="col-md-6" wire:key="batiment-{{ $batiment->id }}">
                <div class="card h-100">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">{{ $batiment->name }}</h3>
                            @if ($batiment->address)
                                <div class="card-subtitle"><i class="ti ti-map-pin"></i> {{ $batiment->address }}</div>
                            @endif
                        </div>
                        <div class="card-actions btn-list">
                            <a class="btn btn-outline-primary" href="{{ route('tabler.some_contrats_pdf', ['batiment_id' => $batiment->id]) }}" target="_blank" title="Contrats du bâtiment en PDF">
                                <i class="ti ti-file-type-pdf"></i> PDF
                            </a>
                            <button class="btn btn-outline-primary btn-icon" wire:click="edit({{ $batiment->id }})" title="Modifier">
                                <i class="ti ti-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($batiment_id == $batiment->id)
                            <form wire:submit="update" class="row">
                                @include('_form.batiment_form')
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" class="btn" wire:click="close">Annuler</button>
                                    <button type="submit" class="btn btn-primary">
                                        <span wire:loading wire:target="update" class="spinner-border spinner-border-sm me-2"></span>Enregistrer
                                    </button>
                                </div>
                            </form>
                        @else
                            @if ($batiment->description)
                                <p class="text-secondary">{{ $batiment->description }}</p>
                            @endif

                            <div class="subheader mb-2">Appartements ({{ $batiment->appartements->count() }})</div>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @forelse ($batiment->appartements as $appartement)
                                    <a href="{{ route('tabler.appartement', ['appartement_id' => $appartement->id]) }}"
                                       class="badge {{ $appartement->statut ? 'bg-green-lt' : 'bg-red-lt' }} text-decoration-none fs-5 py-2 px-2"
                                       title="{{ $appartement->statut ? 'Occupé' : 'Libre' }}">{{ $appartement->nom }}</a>
                                @empty
                                    <span class="text-secondary">Aucun appartement.</span>
                                @endforelse
                            </div>

                            <div class="subheader mb-2">Contrats ({{ $batiment->contrats->count() }})</div>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse ($batiment->contrats->sortBy('client.nom') as $contrat)
                                    <a href="{{ route('tabler.contrat', ['contrat_id' => $contrat->id]) }}" class="badge bg-blue-lt text-decoration-none fs-5 py-2 px-2">
                                        {{ \App\Support\Format::person($contrat->client) }}
                                    </a>
                                @empty
                                    <span class="text-secondary">Aucun contrat.</span>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            @include('components.tabler.empty', ['icon' => 'ti-building', 'title' => 'Aucun bâtiment', 'message' => 'Ajoutez un premier bâtiment avec le bouton « Bâtiment ».'])
        @endforelse
    </div>

    <div class="modal modal-blur fade" id="addBatiment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit="store">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un bâtiment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body row">
                        @if (! $batiment_id)
                            @include('_form.batiment_form')
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></span>Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
