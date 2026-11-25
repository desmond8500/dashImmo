<?php

namespace App\Http\Livewire\Tabler\Concerns;

use Livewire\WithPagination;

/**
 * Pagination Bootstrap (thème Tabler) + retour en page 1 à chaque recherche.
 */
trait InteractsWithPagination
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
