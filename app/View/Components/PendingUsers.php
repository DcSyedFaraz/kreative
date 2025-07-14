<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PendingUsers extends Component
{
    /**
     * Create a new component instance.
     */
    public $users;

    /**
     * Create the component instance.
     *
     * We fetch all users with status = 'pending' here.
     *
     * @return void
     */
    public function __construct()
    {
        $this->users = User::where('status', 'pending')->paginate(2);
    }

    /**
     * Get the view / contents that represent the component.
     */
public function render(): View|Closure|string
{
    return view('components.pending-users');
}

}
