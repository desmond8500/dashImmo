<div class="sticky-top">
    <header class="navbar navbar-expand-md navbar-dark d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="{{ route($index->route) }}" class="text-reset text-decoration-none">
                    <i class="ti ti-building-community me-1"></i>{{ $index->name }}
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item">
                    @auth
                        <button type="button" class="btn btn-light" wire:click="logout">
                            <i class="ti ti-logout"></i> Déconnexion
                        </button>
                    @else
                        <a class="btn btn-primary" href="{{ route('login') }}">
                            <i class="ti ti-login"></i> Connexion
                        </a>
                    @endauth
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        @foreach ($menus as $menu)
                            <li class="nav-item @if (\App\Support\Menu::isActive($menu)) active @endif">
                                <a class="nav-link" href="{{ route($menu->route) }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti {{ $menu->icon }}"></i></span>
                                    <span class="nav-link-title">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>
