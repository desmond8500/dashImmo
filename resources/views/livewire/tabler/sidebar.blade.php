<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route($index->route) }}" class="text-reset text-decoration-none">
                <i class="ti ti-building-community me-1"></i>{{ $index->name }}
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item">
                @auth
                    <button type="button" class="btn btn-light" wire:click="logout"><i class="ti ti-logout"></i> Déconnexion</button>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}"><i class="ti ti-login"></i> Connexion</a>
                @endauth
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
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
</aside>
