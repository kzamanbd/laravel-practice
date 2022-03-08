<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The state validation.
     *
     * @var array
     */
    protected $rules = [
        'state.name' => 'required|min:6',
        'state.email' => 'required|email',
    ];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Update the user's profile information.
     *
     * @return void
     */
    public function updateProfileInformation()
    {
        $this->validate();
        $this->resetErrorBag();
        $profilePhotoPath = $this->photo ? Storage::put('profile-photo', $this->photo) : null;
        $user = $profilePhotoPath ? array_merge($this->state, ['profile_photo_path' => $profilePhotoPath]) : $this->state;
        Auth::user()->update($user);
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
        return view('livewire.update-profile-information-form');
    }
}
