<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Models\User;
use App\Notifications\ArticlePublishedNotification;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendArticlePublishedNotification implements ShouldQueue
{
use InteractsWithQueue,SerializesModels;
   public $tries=4;

   public $backoff=[5,10,30,60];

   public $timeout=120;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticlePublished $event): void
    {
        $subscribers=
        User::whereIn('role', ['admin', 'writer', 'reader'])->whereNotNull('email')->where('email', '!=', '')->where('is_real',true)
    ->chunk(50,function($subscribers)use($event){

        foreach($subscribers as $subscriber){

            try{
                $subscriber->notify(new ArticlePublishedNotification($event->article));
                Log::info('Notification sent to user: ' . $subscriber->email);
            }

            catch (Exception $e){
               Log::error('Failed to send notification to: ' . $subscriber->email, [
                    'error' => $e->getMessage(),
                    'article_id' => $event->article->id,
                ]);

                continue;
            }


        }
        });

    }

    public function failed(ArticlePublished $event,Exception $exception){

   Log::critical('All retry attempts failed for article notification', [
            'article_id' => $event->article->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
