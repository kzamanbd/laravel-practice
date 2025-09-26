<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessLargeDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $largePayload,
        public string $jobId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulate processing large payload data
        $startTime = microtime(true);

        Log::info("Processing job {$this->jobId} with payload size: " . count($this->largePayload) . " items");

        // Simulate data processing time
        sleep(rand(1, 3));

        // Perform actual data processing operations
        $processedData = [];
        foreach ($this->largePayload as $item) {
            // Simulate complex data processing
            usleep(1000); // 1ms delay per item
            $processedData[] = array_merge($item, [
                'processed_at' => now()->toISOString(),
                'processing_time' => microtime(true) - $startTime,
                'job_id' => $this->jobId,
            ]);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        Log::info("Job {$this->jobId} completed in {$executionTime} seconds. Processed: " . count($processedData) . " items");
    }
}
