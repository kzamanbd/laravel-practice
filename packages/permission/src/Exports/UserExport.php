<?php

namespace Draftscripts\Permission\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;

class UserExport extends BaseExportFromView
{
    protected string $freezePane = 'A3';

    protected string $autoFilter = 'B2:E2';

    public function view(): View
    {
        return view('lara-permission::exports.users', [
            'users' => User::query()->latest()->get(),
        ]);
    }
}
