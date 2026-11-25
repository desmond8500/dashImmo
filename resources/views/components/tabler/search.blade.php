{{-- Champ de recherche live : @include('components.tabler.search', ['placeholder' => '…']) --}}
<div class="input-icon">
    <span class="input-icon-addon"><i class="ti ti-search"></i></span>
    <input type="search" class="form-control" wire:model.live.debounce.300ms="search" placeholder="{{ $placeholder ?? 'Rechercher…' }}">
    <span class="input-icon-addon" wire:loading.delay wire:target="search">
        <span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
    </span>
</div>
