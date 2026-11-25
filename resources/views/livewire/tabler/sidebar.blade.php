<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('index') }}">{{ config('app.name') }}</a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                @auth
                    <a class="btn btn-light" wire:click="logout">Déconnexion</a>
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}">Connexion</a>
                @endauth
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                @foreach ($menus as $menu)
                    @if ($menu->route)
                        <li class="nav-item @if (basename(Request::url()) == strtolower($menu->name)) active @endif">
                            <a class="nav-link" href="{{ route($menu->route) }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"> {!! $menu->icon !!} </span>
                                <span class="nav-link-title"> {{ $menu->name }} </span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-third" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"> {!! $menu->icon !!} </span>
                                <span class="nav-link-title"> {{ $menu->name }} </span>
                            </a>
                            <div class="dropdown-menu">
                                @foreach ($menu->submenu as $submenu)
                                    <a class="dropdown-item" href="{{ route($submenu->route) }}">
                                        {{ $submenu->name }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>
