<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;


class ArchiveOldDrafts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:archive  {days=30}
    {--dry-run} :Run the command without making changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'archive old drafts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days=$this->argument('days');

    $articles=Article::draft()
        ->where('created_at','<',now()->subDays($days))->get();
       // ->update(['status'=>'archived']);

    $count=$articles->count();

     if ($count === 0) {

          $this->warn('No old draft articles found to archive 📦');

          return Command::SUCCESS;
    }

    $isDryRun=(bool)$this->option('dry-run');

    if($isDryRun){

    $this->info('🔍 Dry run mode - no changes will be made');

    $this->info("📊 Would archive $count articles:");

    $this->table(['id','title','status','created_at'],
    $articles->map(function($article){
      return [
        $article->id,
        $article->title,
        $article->status,
        $article->created_at
      ];
    }));

       if(!$this->confirm(" ⚠️ Are you sure you want to archive {$count} articles?", false)){

        $this->warn('operation cancelled');
        return Command::SUCCESS;
       }
    }
         $articles=Article::draft()
        ->where('created_at','<',now()->subDays($days))
       ->update(['status'=>'archived']);




         $this->info("{$count} old draft article archived 📦");
        return Command::SUCCESS;




    }
}
