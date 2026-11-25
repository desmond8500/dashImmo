<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => $F::person($client), 'subtitle' => 'Client'])
        <a href="{{ route('tabler.clients') }}" class="btn"><i class="ti ti-arrow-left"></i> Clients</a>
    @endcomponent

    <div class="row row-cards">
        <div class="col-md-5">
            <div class="card">
                <div class="card-status-top {{ $client->statut ? 'bg-green' : 'bg-red' }}"></div>
                <div class="card-header"><h3 class="card-title">Identité</h3></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Prénom</dt><dd class="col-7">{{ $client->prenom }}</dd>
                        <dt class="col-5">Nom</dt><dd class="col-7">{{ mb_strtoupper($client->nom) }}</dd>
                        <dt class="col-5">Genre</dt><dd class="col-7">{{ $client->genre == 'femme' ? 'Femme' : 'Homme' }}</dd>
                        <dt class="col-5">Pièce d'identité</dt><dd class="col-7">{{ $client->ci ?: '—' }}</dd>
                        <dt class="col-5">Délivrance</dt><dd class="col-7">{{ $client->delivre ?: '—' }}</dd>
                        <dt class="col-5">Statut</dt>
                        <dd class="col-7"><span class="badge {{ $client->statut ? 'bg-green-lt' : 'bg-red-lt' }}">{{ $client->statut ? 'Résident' : 'Parti' }}</span></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Location</h3></div>
                <div class="card-body">
                    @if ($contrat = $client->contrat)
                        <dl class="row mb-0">
                            <dt class="col-5">Appartement</dt>
                            <dd class="col-7">
                                @if ($contrat->appartement)
                                    <a href="{{ route('tabler.appartement', ['appartement_id' => $contrat->appartement->id]) }}">{{ $contrat->appartement->nom }}</a>
                                    <div class="text-secondary small">{{ $contrat->appartement->batiment->name ?? '' }} {{ $contrat->appartement->adresse ? '· '.$contrat->appartement->adresse : '' }}</div>
                                @else — @endif
                            </dd>
                            <dt class="col-5">Loyer mensuel</dt><dd class="col-7 fw-bold">{{ $F::money($contrat->montant, 'F CFA') }}</dd>
                            <dt class="col-5">Caution</dt><dd class="col-7">{{ $F::money($contrat->montant * 2, 'F CFA') }}</dd>
                            <dt class="col-5">Date du contrat</dt><dd class="col-7">{{ $F::date($contrat->date) }}</dd>
                            <dt class="col-5">Période</dt><dd class="col-7">{{ $F::date($contrat->debut) }} → {{ $F::date($contrat->fin) }}</dd>
                        </dl>
                        <div class="btn-list mt-3">
                            <a href="{{ route('tabler.contrat', ['contrat_id' => $contrat->id]) }}" class="btn btn-outline-primary">Voir le contrat</a>
                            <a href="{{ route('tabler.contrat_pdf', ['contrat_id' => $contrat->id]) }}" target="_blank" class="btn btn-outline-primary"><i class="ti ti-file-type-pdf"></i> PDF</a>
                        </div>
                    @else
                        <p class="text-secondary mb-2">Ce client n'a pas encore de contrat.</p>
                        <a href="{{ route('tabler.contrats') }}" class="btn btn-primary"><i class="ti ti-plus"></i> Créer un contrat</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
