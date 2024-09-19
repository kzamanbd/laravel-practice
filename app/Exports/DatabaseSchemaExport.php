<?php

namespace App\Exports;


class DatabaseSchemaExport extends BaseExportFromView
{

    public function __construct(private $schema) {}

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.database-schema', [
            'schema' => $this->schema,
        ]);
    }
}
