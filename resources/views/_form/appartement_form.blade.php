<div class="mb-3 col-md-8">
    <label class="form-label required">Nom de l'appartement</label>
    <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror" placeholder="Nom de l'appartement">
    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-4">
    <label class="form-label">Numéro</label>
    <input type="text" wire:model="numero" class="form-control @error('numero') is-invalid @enderror" placeholder="Numéro">
    @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-6">
    <label class="form-label required">Bâtiment</label>
    <select wire:model="batiment_id" class="form-select @error('batiment_id') is-invalid @enderror">
        <option value="">Choisir un bâtiment</option>
        @foreach ($batiments as $batiment)
            <option value="{{ $batiment->id }}">{{ $batiment->name }}</option>
        @endforeach
    </select>
    @error('batiment_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-3">
    <label class="form-label">Niveau</label>
    <select wire:model="niveau" class="form-select">
        @foreach ($niveaux as $n)
            <option value="{{ $n }}">{{ $n }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3 col-md-3">
    <label class="form-label">Statut</label>
    <select wire:model="statut" class="form-select">
        <option value="0">Libre</option>
        <option value="1">Occupé</option>
    </select>
</div>
<div class="mb-3 col-md-12">
    <label class="form-label">Adresse</label>
    <input type="text" wire:model="adresse" class="form-control @error('adresse') is-invalid @enderror" placeholder="Adresse ou description du local">
    @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
