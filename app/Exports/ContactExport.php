<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;

class ContactExport extends BaseExportFromView
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
