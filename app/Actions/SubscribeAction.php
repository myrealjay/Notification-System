<?php
namespace App\Actions;

use App\Http\Requests\SubscriptionRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use App\Models\Topic;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;

class SubscribeAction{
    use HasResponse;

    /**
     * Create subscription record for a subscriber
     *
     * @param SubscriptionRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function execute(SubscriptionRequest $request, string $topic) : JsonResponse{
        $subscriptionTopic = Topic::firstOrCreate(['title' =>  $topic]);

        if(Subscriber::where(['topic_id' => $subscriptionTopic->id,'url' => $request->url])->exists()){
            return $this->existsResponse('Sorry you are already subscribed to this topic');
        }

        return $this->successResponseWithResource(
            'You have successfully subscribed',
            new SubscriberResource(
                Subscriber::create([
                    'url' => $request->url,
                    'topic_id' => $subscriptionTopic->id
                ])
            )
        );
    }
}
