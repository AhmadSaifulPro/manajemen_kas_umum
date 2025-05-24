@php
    $icon =
        [
            'blue' => 'fas fa-wallet',
            'green' => 'fas fa-arrow-up',
            'red' => 'fas fa-arrow-down',
        ][$color] ?? 'fas fa-wallet';

    $bgColor =
        [
            'blue' => 'bg-info',
            'green' => 'bg-success',
            'red' => 'bg-danger',
        ][$color] ?? 'bg-primary';
@endphp

<div class="card">
    <div class="card-body d-flex align-items-center">
        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 {{ $bgColor }}" style="width: 50px; height: 50px;">
            <i class="{{ $icon }} text-white"></i>
        </div>
        <div>
            <p class="mb-0 text-muted">{{ $title }}</p>
            <h5 class="mb-0">Rp {{ number_format($value, 0, ',', '.') }}</h5>
        </div>
    </div>
</div>
