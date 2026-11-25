<div class="mb-3 col-md-12">
    <label class="form-label required">Nom</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Nom du bâtiment" />
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3 col-md-12">
    <label class="form-label">Adresse</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror" wire:model="address" placeholder="Adresse" />
    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3 col-md-12">
    <label class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" rows="3" wire:model="description"></textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
