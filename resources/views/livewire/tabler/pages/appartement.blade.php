<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => $appartement->nom, 'subtitle' => 'Appartement'])
        <a href="{{ route('tabler.appartements') }}" class="btn"><i class="ti ti-arrow-left"></i> Appartements</a>
    @endcomponent

    <div class="row row-cards">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-status-top {{ $appartement->statut ? 'bg-green' : 'bg-red' }}"></div>
                <div class="card-header"><h3 class="card-title">Informations</h3></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Bâtiment</dt><dd class="col-7">{{ $appartement->batiment->name ?? '—' }}</dd>
                        <dt class="col-5">Numéro</dt><dd class="col-7">{{ $appartement->numero ?: '—' }}</dd>
                        <dt class="col-5">Niveau</dt><dd class="col-7">{{ $appartement->niveau ?: '—' }}</dd>
                        <dt class="col-5">Adresse</dt><dd class="col-7">{{ $appartement->adresse ?: '—' }}</dd>
                        <dt class="col-5">Statut</dt>
                        <dd class="col-7"><span class="badge {{ $appartement->statut ? 'bg-green-lt' : 'bg-red-lt' }}">{{ $appartement->statut ? 'Occupé' : 'Libre' }}</span></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header"><h3 class="card-title">Contrat en cours</h3></div>
                <div class="card-body">
                    @if ($contrat = $appartement->contrat)
                        <dl class="row mb-0">
                            <dt class="col-5">Locataire</dt>
                            <dd class="col-7">
                                @if ($contrat->client)
                                    <a href="{{ route('tabler.client', ['client_id' => $contrat->client->id]) }}">{{ $F::person($contrat->client) }}</a>
                                @else — @endif
                            </dd>
                            <dt class="col-5">Loyer</dt><dd class="col-7 fw-bold">{{ $F::money($contrat->montant, 'F CFA') }}</dd>
                            <dt class="col-5">Début</dt><dd class="col-7">{{ $F::date($contrat->debut) }}</dd>
                            <dt class="col-5">Fin</dt><dd class="col-7">{{ $F::date($contrat->fin) }}</dd>
                        </dl>
                        <div class="btn-list mt-3">
                            <a href="{{ route('tabler.contrat', ['contrat_id' => $contrat->id]) }}" class="btn btn-outline-primary">Voir le contrat</a>
                            <a href="{{ route('tabler.contrat_pdf', ['contrat_id' => $contrat->id]) }}" target="_blank" class="btn btn-outline-primary"><i class="ti ti-file-type-pdf"></i> PDF</a>
                        </div>
                    @else
                        <p class="text-secondary mb-0">Aucun contrat associé.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header"><h3 class="card-title">Compteurs</h3></div>
                <div class="list-group list-group-flush">
                    @forelse ($appartement->compteurs as $compteur)
                        <div class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">{{ $compteur->reference ?: '—' }}</span>
                            <span class="badge {{ $compteur->type === 'EAU' ? 'bg-blue-lt' : 'bg-yellow-lt' }}">{{ $compteur->type }}</span>
                        </div>
                    @empty
                        <div class="list-group-item text-secondary">Aucun compteur.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Dernières factures</h3></div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr><th>Numéro</th><th>Compteur</th><th>Date</th><th class="text-end">Montant</th><th></th></tr>
                        </thead>
                        <tbody>
                            @forelse ($factures as $facture)
                                <tr>
                                    <td>{{ $facture->numero ?: '—' }}</td>
                                    <td>{{ $facture->compteur->type ?? '' }} {{ $facture->compteur->reference ?? '' }}</td>
                                    <td>{{ $F::date($facture->date) }}</td>
                                    <td class="text-end">{{ $F::money($facture->montant) }}</td>
                                    <td class="text-end">
                                        @if ($facture->facture)
                                            <a href="{{ asset('storage/'.$facture->facture) }}" target="_blank" class="btn btn-sm btn-ghost-primary"><i class="ti ti-paperclip"></i> Fichier</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-secondary text-center py-4">Aucune facture.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
