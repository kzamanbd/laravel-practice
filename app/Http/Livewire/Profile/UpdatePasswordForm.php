<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * The state validation.
     *
     * @var array
     */
    protected $rules = [
        'state.current_password' => 'required|min:6',
        'state.password' => 'required|email',
        'state.password_confirmation' => 'required|email',
    ];

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updatePassword()
    {
        $this->resetErrorBag();
        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->emit('saved');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty(): User
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}
