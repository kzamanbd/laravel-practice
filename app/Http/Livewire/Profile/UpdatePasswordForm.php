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
    public array $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * The state validation.
     *
     * @var array
     */
    protected array $rules = [
        'state.current_password' => 'required|current_password',
        'state.password' => 'required|confirmed',
    ];
    /**
     * The state validation Attributes.
     *
     * @var array
     */
    protected array $validationAttributes = [
        'state.current_password' => 'current password',
        'state.password' => 'password',
    ];

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updatePassword()
    {
        $this->validate();
        $this->resetErrorBag();
        Auth::user()->update(['password' => bcrypt($this->state['password'])]);
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
     * @return View
     */
    public function render(): View
    {
        return view('livewire.profile.update-password-form');
    }
}
