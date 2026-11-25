<?php

namespace App\Http\Livewire\Tabler;

use App\Support\Menu;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.tabler.sidebar', [
            'menus' => Menu::items(),
            'user' => Auth::user(),
            'index' => (object) ['name' => config('app.name'), 'route' => 'index'],
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
