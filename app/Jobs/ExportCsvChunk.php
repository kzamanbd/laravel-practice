<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Writer;

class ExportCsvChunk implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $filename)
    {
        $this->data = $data;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Create a CSV writer instance
        $csv = Writer::createFromString('');

        // Insert rows
        foreach ($this->data as $row) {
            $csv->insertOne((array)$row);
        }

        // Append CSV data to file
        Storage::append($this->filename, $csv->toString());
    }
}
