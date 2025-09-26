<?php

namespace App\Console\Commands;

use App\Jobs\ProcessLargeDataJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

class DispatchBulkJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:dispatch-bulk {--count=1000 : Number of jobs to dispatch} {--payload-size=1000 : Size of payload per job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a large number of jobs with heavy payloads for testing queue performance';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = (int) $this->option('count');
        $payloadSize = (int) $this->option('payload-size');

        $this->info("Starting to dispatch {$count} jobs with payload size of {$payloadSize} items each...");

        $startTime = microtime(true);
        $successCount = 0;

        // Create progress bar
        $progressBar = $this->output->createProgressBar($count);
        $progressBar->start();

        for ($i = 1; $i <= $count; $i++) {
            try {
                // Generate large payload data
                $largePayload = $this->generateLargePayload($payloadSize);

                // Create unique job ID
                $jobId = 'job-' . Str::uuid() . '-' . $i;

                // Dispatch job to the queue
                ProcessLargeDataJob::dispatch($largePayload, $jobId)
                    ->onQueue('default');

                $successCount++;
                $progressBar->advance();

                // Small delay to avoid overwhelming the system
                usleep(1000); // 1ms delay

            } catch (\Exception $e) {
                $this->error("Failed to dispatch job #{$i}: " . $e->getMessage());
            }
        }

        $progressBar->finish();
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $this->newLine();
        $this->info("Successfully dispatched {$successCount} jobs in {$executionTime} seconds");
        $this->info("Average time per job dispatch: " . number_format($executionTime / $count, 4) . " seconds");

        // Show option to check horizon dashboard
        $this->newLine();
        $this->info("Monitor job progress at: php artisan horizon");
        $this->info("View queue status at: php artisan queue:work --help");

        return self::SUCCESS;
    }

    /**
     * Generate large payload data
     */
    private function generateLargePayload(int $size): array
    {
        $payload = [];

        for ($i = 0; $i < $size; $i++) {
            $payload[] = [
                'id' => $i + 1,
                'data' => [
                    'complex_structure' => [
                        'nested_data' => rand(1, 10000),
                        'timestamps' => [
                            'created_at' => now()->subDays(rand(0, 365))->toISOString(),
                            'updated_at' => now()->toISOString(),
                        ],
                        'metadata' => [
                            'category' => fake()->randomElement(['processing', 'validation', 'transformation', 'aggregation']),
                            'priority' => rand(1, 10),
                            'tags' => fake()->words(3),
                            'source' => fake()->randomElement(['api', 'database', 'file', 'stream']),
                        ],
                    ],
                    'raw_data' => [
                        'str' => fake()->sentence(20),
                        'num' => fake()->randomFloat(4, -1000, 1000),
                        'bool' => fake()->boolean(70),
                        'arr' => fake()->randomElements(['a', 'b', 'c', 'd', 'e'], rand(2, 4)),
                    ],
                    'processing_instructions' => [
                        'transform' => fake()->boolean(),
                        'validate' => fake()->boolean(),
                        'archive' => fake()->boolean(),
                        'notify' => fake()->boolean(),
                    ],
                ],
                'ref' => Str::random(32),
            ];
        }

        return $payload;
    }
}
