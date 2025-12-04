<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImportTempFile;
use App\Jobs\ProcessTempFileJob;

class ProcessImportTempFiles extends Command
{
    protected $signature = 'process:import-temp-files';
    protected $description = 'Process ImportTempFile entries by dispatching to the queue';

    public function handle()
    {
        $this->info('Starting to dispatch ImportTempFile jobs...');

        ImportTempFile::where('created_chunk','0')->chunk(50, function ($tempFiles) {
            foreach ($tempFiles as $tempFile) {
                ProcessTempFileJob::dispatch($tempFile->id);
            }
        });

        $this->info('All jobs dispatched successfully.');
    }
}