<?php

namespace App\Libraries;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Exception;
use Log;

class DrawbridgeApi implements PaymentApi
{
    private $API_BASE_URL = 'http://local-drawbridge.boosterthon.com/v1/';

    public function __construct()
    {
        $this->API_BASE_URL = env('DRAWBRIDGE_API_BASE_URL') ?: $this->API_BASE_URL;
    }

    /**
     * api result looks like this:
     * {
     *     "success": {
     *         "message": "Item Successfully Created",
     *         "status_code": 201,
     *         "location": null
     *     },
     *     "data": {
     *         "transaction": {
     *             "id": "mk2x8qrh",
     *             "status": "authorized",
     *             "currencyIsoCode": "USD",
     *             "amount": "10.02",
     *             "cvvResponseCode": "M",
     *             "processorResponseCode": "1000"
     *         }
     *     }
     * }
     *
     * @return void
     */
    public function authorizePayment($paymentForm, $total, $school, $program, $orderId)
    {
        //call api
        $client       = new Client();
        $uri          = $this->API_BASE_URL . 'transactions/authorize';
        $pledgeAmount = $paymentForm['form']['amount'] * count($paymentForm['form']['students']);
        try {
            $result       = $client->post(
                $uri,
                [
                    'headers' => [
                        'Accept'           => 'application/json',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'form_params'            => [
                        'amount'             => (float) $total,
                        'service_fee_amount' => (float) $program->sponsor_convenience_fee,
                        'order_id'           => $orderId,
                        'nonce'              => $paymentForm['nonce'],
                        'sponsor'            => [
                            'first_name' => $paymentForm['form']['payer']['first_name'],
                            'last_name'  => $paymentForm['form']['payer']['last_name'],
                            'email'      => $paymentForm['form']['payer']['email'],
                        ],
                        'billing' => [
                            'first_name' => $paymentForm['form']['payer']['first_name'],
                            'last_name'  => $paymentForm['form']['payer']['last_name'],
                        ],
                        'descriptor' => [
                            'name'  => $program->event_name,
                            'phone' => env('DESCRIPTOR_PHONE'),
                        ],
                        'options' => [
                            'hold_in_escrow' => (int) $school->braintreeMerchant->escrow_funds,
                        ],
                        'custom_fields' => [
                            'school_id'               => (int) $school->id,
                            'program_id'              => (int) $program->id,
                            'pledge_amount'           => (float) $pledgeAmount,
                            'sponsor_convenience_fee' => (float) $program->sponsor_convenience_fee,
                            'school_name'             => $school->name,
                        ],
                    ],
                ]
            );
            $resultObj = json_decode($result->getBody()->getContents());
        } catch (Exception $exception) {
            Log::emergency($exception);
            $resultObj = (object)[
                'error' => 'drawbridge_fail_retry'
            ];
        }
        return $resultObj;
    }

    public function settlePayment($transaction_id)
    {
        $client = new Client();
        $uri    = $this->API_BASE_URL . 'transactions/settle';
        try {
            $result = $client->post(
                $uri,
                [
                    'headers' => [
                        'Accept'           => 'application/json',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'form_params' => [
                        'transaction_id'  => $transaction_id,
                    ],
                ]
            );
            $resultObj = json_decode($result->getBody()->getContents());
        } catch (Exception $exception) {
            Log::emergency($exception);
            $resultObj = (object)[
                'error' => 'drawbridge_fail'
            ];
        }
        return $resultObj;
    }

    public function getClientID()
    {
        $client =new Client();
        $uri    = $this->API_BASE_URL . 'clientid';
        try {
            $result = $client->get(
                $uri,
                ['headers' => [
                    'Accept'           => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest',
                ]]
            );
            $resultObj = json_decode($result->getBody()->getContents());
            return $resultObj;
        } catch (Exception $exception) {
            Log::emergency($exception);
            abort(500);
        }
    }
}
