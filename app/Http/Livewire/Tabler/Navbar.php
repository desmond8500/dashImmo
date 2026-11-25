<?php

namespace App\Http\Livewire\Tabler;

use App\Support\Menu;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.tabler.navbar', [
            'user' => Auth::user(),
            'menus' => Menu::items(),
            'index' => (object) ['name' => config('app.name'), 'route' => 'index'],
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
