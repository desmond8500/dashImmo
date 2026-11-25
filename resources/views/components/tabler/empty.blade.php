{{-- État vide : @include('components.tabler.empty', ['icon' => 'ti-home', 'title' => '…', 'message' => '…']) --}}
<div class="col-12">
    <div class="card">
        <div class="empty py-5">
            <div class="empty-icon"><i class="ti {{ $icon ?? 'ti-inbox' }}" style="font-size: 3rem"></i></div>
            <p class="empty-title">{{ $title ?? 'Aucun élément' }}</p>
            @if (! empty($message))
                <p class="empty-subtitle text-secondary">{{ $message }}</p>
            @endif
        </div>
    </div>
</div>
