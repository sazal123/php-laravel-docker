<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class FacebookWebhookController extends Controller
{
    private $appId = '1087087365982506';
    private $appSecret = '70162ee7748470487ec99982d0e8aaa5';
    private $userToken = 'EAAOE40S5fRwBO6sZABPlJNH8QdZC9yMOEhqjCFQvrv3oBSZBUPTYfmF3Nun2ZCw5RlZArSB0O71mOEMV7N6HxVYwMYd6Cx8YPgwa5jN0aZBXh1m2dFFhRZCxYpNU3YtfDHTJcTHPyGZB7YGZA6PoYto5Nn4AwS2zZBhxFZByDhNNjXNuZCo1OdKpkwU7shTP';

    public function verifyWebhook(Request $request)
    {
        $verify_token = 'sazal'; // replace with your own token
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verify_token) {
                $webhook = new Webhook();
                $webhook->data = json_encode(['key' => 'value']); // Assuming you're storing JSON data
                $webhook->save();
                return response($challenge, 200);
            } else {
                return response('Forbidden', 403);
            }
        }

    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        $webhook = new Webhook();
        $webhook->data = json_encode(['web' =>$data ]);
        $webhook->save();
        if (isset($payload['entry'][0]['changes'][0]['value']['leadgen_id'])) {
            $leadgenId = $payload['entry'][0]['changes'][0]['value']['leadgen_id'];
        }

        return response('Event received', 200);
    }

    public function logs(){
        print_r(Webhook::all()->toArray());
    }

    public function subscribeAppToPage($pageId, $pageAccessToken)
    {
        $client = new Client();
        $url = "https://graph.facebook.com/v19.0/{$pageId}/subscribed_apps";

        try {
            $response = $client->post($url, [
                'form_params' => [
                    'access_token' => $pageAccessToken
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the subscription was successful
            if (isset($data['success']) && $data['success'] == true) {
                return response()->json(['message' => 'App successfully subscribed to the page'], 200);
            } else {
                return response()->json(['message' => 'Failed to subscribe app to the page'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
