<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@hasSection('title')@yield('title') · @endif{{ config('app.name') }}</title>
<link rel="shortcut icon" href="{{ asset('img/icon/building.png') }}" type="image/png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
@livewireStyles
<style>
    .nav-link-icon .ti { font-size: 1.25rem; }
    .btn .ti { font-size: 1.15rem; margin-right: .25rem; }
    .btn-icon .ti { margin-right: 0; }
    .card-link-hover { transition: transform .1s ease, box-shadow .1s ease; color: inherit; }
    .card-link-hover:hover { transform: translateY(-2px); text-decoration: none; }
    .toast-area { position: fixed; right: 1rem; bottom: 1rem; z-index: 1090; max-width: 22rem; }
</style>
