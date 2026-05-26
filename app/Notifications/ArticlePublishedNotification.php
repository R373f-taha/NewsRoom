<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePublishedNotification extends Notification
{
    use Queueable;

     protected Article $article;
    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article)
    {
        $this->article=$article;

        $this->onQueue('high');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
             ->subject('New Article 📝🎉')
             ->greeting('Hello 🤗💛 '.$notifiable->name)
            ->line('A New Article On TechNova 📲🔥.')
            ->line('💛💛💛 '.$this->article->title .' 💛💛💛')
            ->line('Thank you for using our application! 🤗💛');
    }

    public function toDatabase($notifiable){

        return [
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'message' => '📢 A New article is published ' . $this->article->title,
            'type' => 'article_published',
            'published_at' => now(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
