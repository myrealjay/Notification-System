<?php

namespace App\Broadcasting;

use App\Exceptions\PublishFailedException;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class SubscribersChannel
{
     /**
     * @var Client
     */
    private $client;

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Notifiable $notifiable
     * @param Notification $notification
     *
     * @throws PublishFailedException
     * @return void
     */
    public function send($notifiable, Notification $notification) : void
    {
        $body = $notification->toArray($notifiable);

        $headers = [];

        $request = new Request('POST', $notifiable->url, $headers, json_encode($body));

        try {
            $response = $this->client->send($request);

            if ($response->getStatusCode() !== 200) {
                \Log::error($response);
            }

            \Log::debug('Webhook successfully posted to ' . $notifiable->url);

            return;

        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() !== 410) {
                \Log::error($exception);
            }
        } catch (GuzzleException $exception) {
            \Log::error($exception);
        }

        \Log::error('Notification failed in posting to ' . $notifiable->url);
    }
}
