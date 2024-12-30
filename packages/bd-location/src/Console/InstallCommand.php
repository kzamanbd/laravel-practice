<?php

namespace DraftScripts\BdLocation\Console;

use DraftScripts\BdLocation\Models\District;
use DraftScripts\BdLocation\Models\Division;
use DraftScripts\BdLocation\Models\Union;
use DraftScripts\BdLocation\Models\Upazila;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'location:install')]
class InstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Location controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        // Insert data from JSON file
        $divisions = File::json(__DIR__ . '/../../database/data/divisions.json');
        $districts = File::json(__DIR__ . '/../../database/data/districts.json');
        $upazilas = File::json(__DIR__ . '/../../database/data/upazilas.json');
        $unions = File::json(__DIR__ . '/../../database/data/unions.json');

        if (!Schema::hasTable('divisions')) {
            $this->components->error('There are no [Division] table exists, please create table first, run migrate commands');
            return 1;
        }

        if (!Schema::hasTable('districts')) {
            $this->components->error('There are no [District] table exists, please create table first, run migrate commands');
            return 1;
        }

        if (!Schema::hasTable('upazilas')) {
            $this->components->error('There are no [Upazila] table exists, please create table first, run migrate commands');
            return 1;
        }

        if (!Schema::hasTable('unions')) {
            $this->components->error('There are no [Union] table exists, please create table first, run migrate commands');
            return 1;
        }

        $divisions_count = DB::table('divisions')->count();
        $districts_count = DB::table('districts')->count();
        $upazilas_count = DB::table('upazilas')->count();
        $unions_count = DB::table('unions')->count();

        if ($divisions_count > 0 || $districts_count > 0 || $upazilas_count > 0 || $unions_count > 0) {
            $this->components->error("The Location command already executed, please truncate location related tables, [e.g.: divisions,districts,upazilas,unions] first, and run migrate commands");
            return 1;
        }

        try {
            DB::transaction(function () use ($divisions, $districts, $upazilas, $unions) {
                DB::table('divisions')->insert($divisions['data']);
                DB::table('districts')->insert($districts['data']);
                DB::table('upazilas')->insert($upazilas['data']);
                DB::table('unions')->insert($unions['data']);

                $this->components->info('Data Successfully Installed');

                return 0;

            }, 5);
        } catch (\Exception $e) {
            $this->components->error('Failed to install command:');
        }

        return 0;
    }
}
