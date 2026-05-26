<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RegisterMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Number of  published articles per writer during current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start=now()->startOfMonth();
        $end=now()->endOfMonth();

        $writers=User::where('role','writer')->get();

       $this->info("📊 Monthly Report - Published Articles Per Write");
       $this->info("📅 Period: " . $start->format('Y-m-d') . " → " . $end->format('Y-m-d'));
       $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        foreach($writers as $writer){

        $count=Article::where('author_id',$writer->id)
        ->where('status','published')
        ->whereBetween('published_at',[$start,$end])
        ->count();


    if ($count > 0) {
        Log::info("✍️ Writer: {$writer->name}");
        Log::info("   📄 Published Articles: {$count}");
        Log::info("────────────────────────────────────────");

        $this->info("✍️ Writer: {$writer->name}");
        $this->info("   📄 Published Articles: {$count}");
       $this->info("────────────────────────────────────────");
    }
        }

        $this->info("✅ Report generated successfully at " . now());

    }
}
