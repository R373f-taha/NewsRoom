<?php

namespace App\Console\Commands;

use App\Models\ApiLog;
use Illuminate\Console\Command;

class CleanApiLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean-api {days=30 : The number of days to keep logs}
    {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean API logs older than a specified number of days';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $days = (int) $this->argument('days');

        $logs=ApiLog::where('created_at', '<', now()->subDays($days));

        $count= $logs->count();

        if($count===0){

        $this->info("No api logs order than {$days} days found");

        return Command::SUCCESS;

        }

        $isDryRun= (bool) $this->option('dry-run');

        if($isDryRun){

            $this->info('🔍 Dry run mode - no changes will be made');

              $sample=$logs->take(5)->get(['id','full_url','method','created_at']);

              if($sample->isNotEmpty()){

                $this->table(['ID', 'full_url', 'Method', 'Created At']

                ,$sample->map(function($log){
                    return [
                        $log->id,
                        $log->full_url,
                        $log->method,
                        $log->created_at
                    ];
                }));
              }

              if(!$this->confirm(" ⚠️ Are you sure you want to delete all api logs ?", false)){

              $this->warn('operation cancelled');

                  return Command::SUCCESS;
       }
        }

        $deleted=$logs->delete();

        $this->info("Deleted $deleted API logs older than $days days.");
    }
}
