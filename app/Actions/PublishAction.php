<?php
namespace App\Actions;

use App\Http\Requests\PublishRequest;
use App\Jobs\MessagePublishJob;
use App\Models\Message;
use App\Models\Topic;
use App\Notifications\MessagePublishedNotification;
use App\Traits\HasResponse;

class PublishAction{
    use HasResponse;

    /**
     * publishes message to a topic
     *
     * @param PublishRequest $request
     * @param string $topic
     * @return void
     */
    public function execute(PublishRequest $request, string $topic){

        $subscriptionTopic = Topic::with('subscribers')->where('title',$topic)->first();

        if(!$subscriptionTopic){
            return $this->notFoundResponse('Sorry the topic you are publishing to does not exist');
        }

        $message = Message::create([
            'topic_id' => $subscriptionTopic->id,
            'content' => json_encode($request->all())
        ]);

        foreach($subscriptionTopic->subscribers as $subscriber){
            dispatch(new MessagePublishJob($subscriber, $topic,$message));
        }

        return $this->successResponse("You have successfully published message to $topic");

    }
}
