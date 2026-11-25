<!doctype html>
<html lang="fr">
<head>
    @include('app._head')
</head>

<body class="antialiased">
    <div class="page">
        @livewire('tabler.sidebar')
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('app._scripts')
</body>

</html>
