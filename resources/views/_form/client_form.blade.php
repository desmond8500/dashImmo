<div class="mb-3 col-md-6">
    <label class="form-label required">Prénom</label>
    <input type="text" wire:model="prenom" class="form-control @error('prenom') is-invalid @enderror" placeholder="Prénom">
    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label required">Nom</label>
    <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror" placeholder="Nom">
    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label">Numéro d'identité</label>
    <input type="text" wire:model="ci" class="form-control @error('ci') is-invalid @enderror" placeholder="Carte d'identité ou passeport">
    @error('ci') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label">Délivrance</label>
    <input type="text" wire:model="delivre" class="form-control @error('delivre') is-invalid @enderror" placeholder="Date et lieu de délivrance">
    @error('delivre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label">Genre</label>
    <select wire:model="genre" class="form-select @error('genre') is-invalid @enderror">
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select>
    @error('genre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label">Statut</label>
    <select wire:model="statut" class="form-select">
        <option value="1">Résident</option>
        <option value="0">Parti</option>
    </select>
</div>
