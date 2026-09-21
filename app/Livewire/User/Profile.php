<?php

declare(strict_types=1);

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class Profile extends Component
{
    public function render(): View
    {
        return view('livewire.user.profile')->title(__('profile.title'));
    }
}
