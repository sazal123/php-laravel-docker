<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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
                Log::info('Facebook Webhook Data: ');
                return response($challenge, 200);
            } else {
                return response('Forbidden', 403);
            }
        }

    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        print_r($data);
        if (isset($payload['entry'][0]['changes'][0]['value']['leadgen_id'])) {
            $leadgenId = $payload['entry'][0]['changes'][0]['value']['leadgen_id'];
        }
        Log::info('Facebook Webhook Datas: ',$data);

        return response('Event received', 200);
    }

}
