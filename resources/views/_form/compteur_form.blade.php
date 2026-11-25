<div class="mb-3 {{ $col ?? 'col-md-12' }}">
    <label class="form-label required">Numéro de compteur</label>
    <input type="text" wire:model="cpt_number" class="form-control @error('cpt_number') is-invalid @enderror" placeholder="Numéro du compteur">
    @error('cpt_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 {{ $col ?? 'col-md-12' }}">
    <label class="form-label required">Type de compteur</label>
    <select wire:model="cpt_type" class="form-select @error('cpt_type') is-invalid @enderror">
        @foreach ($types as $t)
            <option value="{{ $t }}">{{ $t }}</option>
        @endforeach
    </select>
    @error('cpt_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3 col-md-12">
    <label class="form-label required">Appartement associé</label>
    <select wire:model="appartement_id" class="form-select @error('appartement_id') is-invalid @enderror">
        <option value="">Choisir un appartement</option>
        @foreach ($apparts as $appart)
            <option value="{{ $appart->id }}">{{ $appart->nom }}</option>
        @endforeach
    </select>
    @error('appartement_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
