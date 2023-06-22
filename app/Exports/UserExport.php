<?php

namespace App\Exports;

use Dompdf\Dompdf;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserExport extends BaseExportFromView
{
    protected string $freezePane = 'A3';
    protected string $autoFilter = 'B2:E2';

    public function view(): View
    {
        return view('exports.users', [
            'users' => User::query()->latest()->get()
        ]);
    }

    public function pdf()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->view());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $name = 'users-' . now()->format('Y-m-d') . '.pdf';
        return $dompdf->stream($name, ['Attachment' => false]);
    }
}
