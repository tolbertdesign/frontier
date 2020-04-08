<?php

namespace App\Models;

use App\Entities\Microsite;
use App\Entities\User;
use Illuminate\Support\Facades\Log;

class StudentStarModel
{
    /**
     * Undocumented function
     *
     * @param object $imageEndpoints
     * @param int $userId
     * @param string $participantName
     * @param string $eventName
     * @return string|bool
     */
    public function createJob($participantImageEndpoint, $userId, $participantName, $eventName)
    {
        if (! $participantImageEndpoint) {
            return;
        }
        $videoPost = [
            'user_id'          => $userId,
            'school_name'      => $eventName,
            'participant_name' => $participantName,
            'callback_url'     => env('APP_URL') . '/api/hero_video',
            'image_endpoints'  => json_encode($this->getImageEndpoints($userId, $participantImageEndpoint))
        ];

        $result = $this->sendRequest('render_jobs', 'POST', $videoPost);
        return $result;
    }

    private function getImageEndpoints($userId, $participantImageEndpoint)
    {
        $user           = User::find($userId);
        $program        = $user->getProgram();
        $microsite      = $program->microsite;
        $imageEndpoints = (object)[
            'kid'             => $participantImageEndpoint,
            'fundsRaisedFor1' => $this->getFundsRaisedFor1($microsite)
        ];
        return $imageEndpoints;
    }

    private function getFundsRaisedFor1(Microsite $microsite)
    {
        $result = $microsite->fundsRaisedImageUrls()->first();
        if ($result) {
            return $result;
        }
        return $microsite->getDefaultFundsRaisedImage1();
    }

    public function cancelJobsBy($userId)
    {
        $uri    = 'users/' . $userId . '/render_jobs';
        $result = $this->sendRequest($uri, 'DELETE');
    }

    /**
     * Send requests to the Student Star API
     * @param  str     $obj     the object to interact with (render_jobs, statuses, etc)
     * @param  str     $method  http method to use
     * @param  int     $id      ID of a specific object
     * @param  array   $data    Data to use for POST and PUT methods
     *
     * @return json  The result of the call
     */
    public function sendRequest($uri, $method = 'GET', $data = null)
    {
        $ch = curl_init();

        // Set the url, number of vars
        curl_setopt($ch, CURLOPT_URL, $this->getEndpoint($uri));
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Set Options Based on HTTP Method
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif (in_array($method, ['PUT', 'DELETE'])) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        } else {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        $result = curl_exec($ch);

        if (curl_error($ch)) {
            Log::error('API call failed: ' . curl_error($ch));
            Log::error('error, URL = ' . $this->getEndpoint($uri));
        }

        curl_close($ch);

        return $result;
    }

    /**
     * Return the full URL for the request
     * @param  str $obj the object to interact with (render_jobs, statuses, etc)
     * @param  int $id  ID of a specific object
     *
     * @return str      the full url
     */
    public function getEndpoint($uri)
    {
        $url = env('SSAPI_ENDPOINT') . '/' . $uri;
        return $url;
    }
}
