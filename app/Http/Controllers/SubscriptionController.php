<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeAction;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    /**
     * create suubscription record
     *
     * @param SubscriptionRequest $request
     * @param string $topic
     * @return JsonResponse
     */
    public function store(SubscriptionRequest $request, string $topic) : JsonResponse{
        return app(SubscribeAction::class)->execute($request, $topic);
    }
}
