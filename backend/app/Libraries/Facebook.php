<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Log;

class Facebook
{
    const OPEN_GRAPH_URL = 'https://graph.facebook.com';

    public static function executeOpenGraphScrape($url)
    {
        $client = new Client();

        try {
            $result = $client->post(
                self::OPEN_GRAPH_URL,
                [
                    'timeout'           => 3, // Response timeout
                    'connect_timeout'   => 3, // Connection timeout
                    'form_params' => [
                        'id'           => $url,
                        'scrape'       => true,
                        'access_token' => Config::get('booster.facebook_access_token')
                    ]
                ]
            );

            $resultObj = $result->getBody()->getContents();
        } catch (Exception $exception) {
            Log::error('Facebook Error');
            Log::error($exception);
        }
    }
}
