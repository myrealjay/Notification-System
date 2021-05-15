<?php

namespace App\Http\Controllers;

use App\Actions\PublishAction;
use App\Http\Requests\PublishRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    /**
     * publishes a message to a toic
     *
     * @param string $topic
     * @param PublishRequest $request
     * @return JsonResponse
     */
    public function store(PublishRequest $request, string $topic) : JsonResponse{
        return app(PublishAction::class)->execute($request, $topic);
    }
}
