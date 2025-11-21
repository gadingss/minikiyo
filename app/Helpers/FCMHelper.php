<?php

namespace App\Helpers;

use Google\Client;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Log;

class FCMHelper
{
    public static function send($target, $title, $body)
    {
        try {
            $keyPath = base_path(env('FIREBASE_CREDENTIALS'));
            if (!file_exists($keyPath)) {
                throw new \Exception("Firebase key file not found at {$keyPath}");
            }

            $client = new Client();
            $client->setAuthConfig($keyPath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

            $httpClient = new HttpClient();

            $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];
            $projectId = json_decode(file_get_contents($keyPath), true)['project_id'];

            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            $data = [
                'message' => [
                    'token' => $target, // bisa juga 'topic' => 'promo'
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                ],
            ];

            $response = $httpClient->post($url, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $data,
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }
}
