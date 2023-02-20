<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UserExport implements FromView, WithColumnWidths
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.users', [
            'users' => User::query()->latest()->get()
        ]);
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 30,
            'D' => 20,
        ];
    }
}
