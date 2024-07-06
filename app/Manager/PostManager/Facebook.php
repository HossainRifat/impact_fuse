<?php

namespace App\Manager\PostManager;

use App\Models\Post;
use GuzzleHttp\Client;

class Facebook
{
    public function post(Post $post): void
    {
        $client = new Client();
        $response = $client->request('POST', 'https://graph.facebook.com/v20.0/102398555754069/feed', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => 'Hello everyone!',
                'link' => '',
                'published' => $post->is_post_immediate ? 'true' : 'false',
                'scheduled_publish_time' => strtotime($post->post_time),
            ],
        ]);

        dd($response->getBody());
    }
}
