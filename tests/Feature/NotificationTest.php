<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Testing for subscription
     *
     * @test
     * @return void
     */
    public function ItCanSubscribeUsers()
    {
        $data = [
            "url" => "https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3"
        ];
        $response = $this->post('/subscribe/another',$data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscribers',['url'=>'https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3']);

        $response->assertJson(['message' => 'You have successfully subscribed']);
    }

    /**
     * user cannot subscribe to same topic twice
     *
     * @return void
     */
    public function YouCantSubscribeToSameTopicTwice(){
        $data = [
            "url" => "https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3"
        ];
        $response = $this->post('/subscribe/another',$data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscribers',['url'=>'https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3']);

        $response->assertJson(['message' => 'You have successfully subscribed']);

        $data = [
            "url" => "https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3"
        ];
        $response = $this->post('/subscribe/another',$data);

        $response->assertStatus(406);

        $response->assertJson(['message' => 'Sorry you are already subscribed to this topic']);
    }

    /**
     * testing that the body must be a javascript array
     *
     * @test
     * @return void
     */
    public function SuppliedDataMustBeJavascriptObject(){

        $data = [
            "url" => "https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3"
        ];
        $response = $this->post('/subscribe/another',$data);

        $response->assertStatus(200);

        $data = [
            ['contentOne' => 'My content']
        ];
        $response = $this->post('/publish/another',$data);

        $response->assertStatus(406);

        $response->assertJson(['data' => [['The supplied body must be a javascript object']]]);

    }

    /**
     * testing for publishing a message to a topic
     *
     * @test
     * @return void
     */
    public function itPushesMessagesToTopic(){
        $data = [
            "url" => "https://webhook.site/1fbcd73f-eab4-4d9b-9c91-e59fc2c019d3"
        ];
        $response = $this->post('/subscribe/another',$data);

        $response->assertStatus(200);

        $data = [
            'contentOne' => 'My content'
        ];
        $response = $this->post('/publish/another',$data);

        $response->assertStatus(200);
    }
}
