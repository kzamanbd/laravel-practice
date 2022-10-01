<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactList extends Component
{


    public $openModal, $perPage = 25;


    public function getContactsProperty()
    {
        return Contact::query()->paginate($this->perPage);
    }
    public function render()
    {
        return view('livewire.contact-list')
            ->layoutData(['title' => 'Contact List']);
    }
}
