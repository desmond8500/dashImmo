<div>
    @php($F = \App\Support\Format::class)
    @component('components.tabler.header', ['title' => 'Contrat de '.$F::person($contrat->client), 'subtitle' => 'Contrat'])
        <a href="{{ route('tabler.contrats') }}" class="btn"><i class="ti ti-arrow-left"></i> Contrats</a>
        <a href="{{ route('tabler.contrat_pdf', ['contrat_id' => $contrat->id]) }}" class="btn btn-primary" target="_blank">
            <i class="ti ti-file-type-pdf"></i> Contrat PDF
        </a>
    @endcomponent

    <div class="row row-cards">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header"><h3 class="card-title">Client</h3></div>
                <div class="card-body">
                    @if ($client = $contrat->client)
                        <dl class="row mb-0">
                            <dt class="col-5">Nom</dt>
                            <dd class="col-7"><a href="{{ route('tabler.client', ['client_id' => $client->id]) }}">{{ $F::person($client) }}</a></dd>
                            <dt class="col-5">Pièce d'identité</dt><dd class="col-7">{{ $client->ci ?: '—' }}</dd>
                            <dt class="col-5">Délivrance</dt><dd class="col-7">{{ $client->delivre ?: '—' }}</dd>
                            <dt class="col-5">Statut</dt>
                            <dd class="col-7"><span class="badge {{ $client->statut ? 'bg-green-lt' : 'bg-red-lt' }}">{{ $client->statut ? 'Résident' : 'Parti' }}</span></dd>
                        </dl>
                    @else
                        <p class="text-secondary mb-0">Client introuvable.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header"><h3 class="card-title">Contrat</h3></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Type</dt><dd class="col-7">{{ ucfirst($contrat->type ?: '—') }}</dd>
                        <dt class="col-5">Date</dt><dd class="col-7">{{ $F::date($contrat->date) }}</dd>
                        <dt class="col-5">Début</dt><dd class="col-7">{{ $F::date($contrat->debut) }}</dd>
                        <dt class="col-5">Fin</dt><dd class="col-7">{{ $F::date($contrat->fin) }}</dd>
                        <dt class="col-5">Loyer</dt><dd class="col-7 fw-bold">{{ $F::money($contrat->montant, 'F CFA') }}</dd>
                        <dt class="col-5">Caution</dt><dd class="col-7">{{ $F::money($contrat->montant * 2, 'F CFA') }}</dd>
                        <dt class="col-5">Signature</dt><dd class="col-7">{{ $contrat->sign1 ? 'Active' : 'Inactive' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header"><h3 class="card-title">Appartement</h3></div>
                <div class="card-body">
                    @if ($appart = $contrat->appartement)
                        <dl class="row mb-0">
                            <dt class="col-5">Nom</dt>
                            <dd class="col-7"><a href="{{ route('tabler.appartement', ['appartement_id' => $appart->id]) }}">{{ $appart->nom }}</a></dd>
                            <dt class="col-5">Numéro</dt><dd class="col-7">{{ $appart->numero ?: '—' }}</dd>
                            <dt class="col-5">Bâtiment</dt><dd class="col-7">{{ $appart->batiment->name ?? '—' }}</dd>
                            <dt class="col-5">Niveau</dt><dd class="col-7">{{ $appart->niveau ?: '—' }}</dd>
                            <dt class="col-5">Adresse</dt><dd class="col-7">{{ $appart->adresse ?: '—' }}</dd>
                        </dl>
                    @else
                        <p class="text-secondary mb-0">Appartement introuvable.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
