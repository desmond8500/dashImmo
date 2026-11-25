<div class="mb-3 col-md-6">
    <label class="form-label required">Client</label>
    <select class="form-select @error('client_id') is-invalid @enderror" wire:model="client_id">
        <option value="">Choisir un client</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}">{{ \App\Support\Format::person($client) }}</option>
        @endforeach
    </select>
    @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label required">Appartement</label>
    <select class="form-select @error('appartement_id') is-invalid @enderror" wire:model="appartement_id">
        <option value="">Choisir un appartement</option>
        @foreach ($appartements as $appartement)
            <option value="{{ $appartement->id }}">{{ $appartement->nom }}</option>
        @endforeach
    </select>
    @error('appartement_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label required">Loyer mensuel (F CFA)</label>
    <input type="number" min="0" step="1" class="form-control @error('montant') is-invalid @enderror" wire:model="montant">
    @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label required">Type</label>
    <select class="form-select @error('type') is-invalid @enderror" wire:model="type">
        @foreach ($types as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label">Signature</label>
    <select class="form-select" wire:model="sign1">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>
<div class="mb-3 col-md-4">
    <label class="form-label">Date du contrat</label>
    <input type="date" class="form-control @error('date') is-invalid @enderror" wire:model="date">
    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label">Début</label>
    <input type="date" class="form-control @error('debut') is-invalid @enderror" wire:model="debut">
    @error('debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label">Fin</label>
    <input type="date" class="form-control @error('fin') is-invalid @enderror" wire:model="fin">
    @error('fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
