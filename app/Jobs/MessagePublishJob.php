<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Subscriber;
use App\Notifications\MessagePublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessagePublishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public Subscriber $subscriber;
     public string $topic;
     public Message $message;

     /**
      * queues messaging for the published topic
      *
      * @param Subscriber $subscriber
      * @param string $topic
      * @param Message $message
      */
    public function __construct(Subscriber $subscriber,string $topic, Message $message)
    {
        $this->subscriber = $subscriber;
        $this->message = $message;
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->subscriber->notify(new MessagePublishedNotification([
                'topic' => $this->topic,
                'data' => $this->message->content
            ])
        );
    }
}
