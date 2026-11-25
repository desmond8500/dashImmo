<div>
    @component('components.tabler.header', ['title' => 'Tableau de bord', 'subtitle' => 'Vue d\'ensemble'])
    @endcomponent

    <div class="row row-cards">
        @foreach ($cards as $card)
            <div class="col-sm-6 col-lg-4">
                <a class="card card-sm card-link card-link-hover" href="{{ route("tabler.$card->route") }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="{{ $card->color }} text-white avatar"><i class="ti {{ $card->icon }}" style="font-size: 1.4rem"></i></span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $card->name }}</div>
                                <div class="text-secondary">{{ $card->description }}</div>
                            </div>
                            <div class="col-auto">
                                <span class="h1 mb-0">{{ $card->count }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Taux d'occupation</div>
                    <div class="d-flex align-items-baseline">
                        <div class="h1 mb-2 me-2">{{ $stats->taux }} %</div>
                    </div>
                    <div class="progress progress-sm mb-2">
                        <div class="progress-bar bg-green" style="width: {{ $stats->taux }}%" role="progressbar" aria-valuenow="{{ $stats->taux }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-secondary">{{ $stats->occupes }} occupé(s) · {{ $stats->libres }} libre(s) sur {{ $stats->appartements }}</div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="subheader">Loyers mensuels (clients résidents)</div>
                    <div class="h1 mb-0">{{ \App\Support\Format::money($stats->loyers, 'F CFA') }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Appartements libres</h3>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($libres as $appart)
                        <a href="{{ route('tabler.appartement', ['appartement_id' => $appart->id]) }}" class="list-group-item list-group-item-action">
                            <div class="fw-bold">{{ $appart->nom }}</div>
                            <div class="text-secondary small">{{ $appart->batiment->name ?? 'Sans bâtiment' }} · {{ $appart->niveau }}</div>
                        </a>
                    @empty
                        <div class="list-group-item text-secondary">Tous les appartements sont occupés.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Dernières factures</h3>
                    <div class="card-actions">
                        <a href="{{ route('tabler.factures') }}" class="btn btn-sm">Tout voir</a>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($factures as $facture)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col text-truncate">
                                    <div class="fw-bold">{{ $facture->compteur->appartement->nom ?? '—' }}</div>
                                    <div class="text-secondary small">N° {{ $facture->numero ?: '—' }} · {{ \App\Support\Format::date($facture->date) }}</div>
                                </div>
                                <div class="col-auto fw-bold">{{ \App\Support\Format::money($facture->montant) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-secondary">Aucune facture enregistrée.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
