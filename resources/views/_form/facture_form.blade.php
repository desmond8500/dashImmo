@php($uid = $facture_id ? 'edit' : 'new')
<div class="mb-3 col-12">
    <label class="form-label required">Compteur</label>
    <select wire:model="compteur_id" class="form-select @error('compteur_id') is-invalid @enderror">
        <option value="">Choisir un compteur</option>
        @foreach ($compteurs as $compteur)
            <option value="{{ $compteur->id }}">{{ $compteur->appartement->nom ?? 'Sans appartement' }} — {{ $compteur->type }} {{ $compteur->reference }}</option>
        @endforeach
    </select>
    @error('compteur_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 {{ $col ?? 'col-md-6' }}">
    <label class="form-label required">Montant (F CFA)</label>
    <input type="number" min="0" step="1" wire:model="montant" class="form-control @error('montant') is-invalid @enderror">
    @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 {{ $col ?? 'col-md-6' }}">
    <label class="form-label required">Date</label>
    <input type="date" wire:model="date" class="form-control @error('date') is-invalid @enderror">
    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 {{ $col ?? 'col-md-6' }}">
    <label class="form-label">Numéro de facture</label>
    <input type="text" wire:model="numero" class="form-control @error('numero') is-invalid @enderror">
    @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 {{ $col ?? 'col-md-6' }}">
    <label class="form-label">Fichier (PDF ou image, 5 Mo max)</label>
    <input type="file" wire:model="facture" id="facture-file-{{ $uid }}-{{ $upload_iteration }}" wire:key="facture-file-{{ $uid }}-{{ $upload_iteration }}" accept=".pdf,image/*" class="form-control @error('facture') is-invalid @enderror">
    <div wire:loading wire:target="facture" class="small text-secondary mt-1">Envoi du fichier…</div>
    @error('facture') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
