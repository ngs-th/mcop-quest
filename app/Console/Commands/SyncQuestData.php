<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Sync\CsvImportService;
use Exception;

class SyncQuestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcop:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from local CSV files in docs/ folder';

    /**
     * Execute the console command.
     */
    public function handle(CsvImportService $importService)
    {
        $this->info('Starting CSV Data Import...');

        $basePath = base_path('docs');
        
        $files = [
            'flows' => "$basePath/MCOP-Dashboard - Flows.csv",
            'ui_tasks' => "$basePath/MCOP-Dev - UI-tasks.csv",
            'api_tasks' => "$basePath/MCOP-Dev - API-tasks.csv",
            'fe_tasks' => "$basePath/MCOP-Dev - FE-tasks.csv",
            'bugs' => "$basePath/MCOP-Dev - Bugs.csv",
        ];

        try {
            $importService->import($files);
            $this->info('CSV Data Import Complete!');
        } catch (Exception $e) {
            $this->error('Import Failed: ' . $e->getMessage());
        }
    }
}
