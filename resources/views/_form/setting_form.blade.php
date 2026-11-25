<div class="col-md-12 mb-3">
    <label class="form-label required">Clé</label>
    <input type="text" class="form-control @error('key') is-invalid @enderror" wire:model="key" placeholder="ex. start_date">
    @error('key') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Valeur</label>
    <input type="text" class="form-control @error('value') is-invalid @enderror" wire:model="value" placeholder="Valeur">
    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
