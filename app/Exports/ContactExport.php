<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactExport implements FromView
{

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.contacts', [
            'contacts' => Contact::query()->latest()->get()
        ]);
    }
}
