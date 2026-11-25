<?php

namespace App\Http\Livewire\Tabler\Concerns;

/**
 * Retours visuels communs aux pages : notification (toast) et fermeture
 * d'une modale Bootstrap une fois l'action réussie. Les écouteurs JS sont
 * dans resources/views/app/_scripts.blade.php.
 */
trait InteractsWithUi
{
    protected function notify(string $message, string $type = 'success'): void
    {
        $this->dispatch('notify', message: $message, type: $type);
    }

    protected function closeModal(string $id): void
    {
        $this->dispatch('close-modal', id: $id);
    }
}
