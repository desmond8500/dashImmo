<div>
    @component('components.tabler.header', ['title' => 'Compteurs', 'subtitle' => 'Eau et électricité'])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCompteur" wire:click="create">
            <i class="ti ti-plus"></i> Compteur
        </button>
        <a class="btn btn-outline-primary" target="_blank" href="{{ route('tabler.appartement_compteurs_pdf') }}">
            <i class="ti ti-file-type-pdf"></i> PDF
        </a>
    @endcomponent

    <div class="row g-2 mb-3">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text"><i class="ti ti-search"></i></span>
                <input type="{{ $search_type }}" class="form-control" wire:model.live.debounce.300ms="search" placeholder="Numéro de compteur ou appartement…">
                <button class="btn" type="button" wire:click="toggle_type" title="Basculer clavier numérique / texte">
                    {{ $search_type == 'number' ? '123' : 'Abc' }}
                </button>
            </div>
        </div>
        <div class="col-12 col-sm-auto">
            <select class="form-select" wire:model.live="filtre_type">
                <option value="">Tous les types</option>
                @foreach ($types as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row row-cards">
        @forelse ($compteurs as $compteur)
            <div class="col-md-6 col-xl-4" wire:key="compteur-{{ $compteur->id }}">
                <div class="card h-100">
                    <div class="card-body">
                        @if ($compteur_id == $compteur->id)
                            <form wire:submit="update" class="row">
                                @include('_form.compteur_form')
                                <div class="col-12 d-flex gap-2">
                                    <button type="button" wire:click="delete" wire:confirm="Supprimer ce compteur ?" class="btn btn-outline-danger btn-icon me-auto" title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                    <button type="button" wire:click="close" class="btn">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        @else
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar {{ $compteur->type === 'EAU' ? 'bg-blue-lt' : 'bg-yellow-lt' }}">
                                        <i class="ti {{ $compteur->type === 'EAU' ? 'ti-droplet' : 'ti-bolt' }}"></i>
                                    </span>
                                </div>
                                <div class="col text-truncate">
                                    @if ($compteur->appartement)
                                        <a href="{{ route('tabler.appartement', ['appartement_id' => $compteur->appartement->id]) }}" class="fw-bold text-reset">{{ $compteur->appartement->nom }}</a>
                                    @else
                                        <span class="text-secondary">Sans appartement</span>
                                    @endif
                                    <div class="h2 mb-0 font-monospace">{{ $compteur->reference ?: '—' }}</div>
                                </div>
                                <div class="col-auto text-end">
                                    <button class="btn btn-ghost-primary btn-icon" wire:click="edit({{ $compteur->id }})" title="Modifier">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <div class="mt-1"><span class="badge {{ $compteur->type === 'EAU' ? 'bg-blue-lt' : 'bg-yellow-lt' }}">{{ $compteur->type }}</span></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            @include('components.tabler.empty', ['icon' => 'ti-gauge', 'title' => 'Aucun compteur', 'message' => $search || $filtre_type ? 'Aucun résultat pour ces critères.' : 'Ajoutez un premier compteur.'])
        @endforelse
    </div>

    @if ($compteurs->hasPages())
        <div class="mt-3">{{ $compteurs->links() }}</div>
    @endif

    <div wire:ignore.self class="modal modal-blur fade" id="modalCompteur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form wire:submit="store" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un compteur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body row">
                    @if (! $compteur_id)
                        @include('_form.compteur_form', ['col' => 'col-md-6'])
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></span>Ajouter le compteur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
