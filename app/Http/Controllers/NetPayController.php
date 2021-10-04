<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class NetPayController extends Controller
{
    public function netpayIntentPay(Request $request, User $user)
    {
        $client = new Client([


        ]);

        $method = 'POST';
        $requestUrl = 'https://gateway-154.netpaydev.com/gateway-ecommerce/v3.2/checkout/session/';
        $isJsonRequest = true;

        $formParams = [
            'successUrl' => 'http://example.com/success',
            'cancelUrl' => 'http://example.com/success',
            'customerEmail' => 'accept@netpay.com.mx',
            'customerName' => 'Jon Doe',
            'paymentMethodTypes' => ['card'],
            'merchantRefCode' => 'test-11124',
            'lineItems' => [
                [
                    'name' => 'P280921/92',
                    'amount' => 5030,
                    'quantity' => 1,
                    'currency' => 'MXN'
                ]
            ],
            'billing' => [
                'firstName' => 'Jon',
                'lastName' => 'Doe',
                'email' => 'accept@netpay.com.mx',
                'phone' => '6141870165',
                'address' => [
                    'city' => 'Monterrey',
                    'country' => 'MX',
                    'postalCode' => '67186',
                    'state' => 'Nuevo Leon',
                    'street1' => 'Filosofos 100',
                    'street2' => 'Tecnologico'
                ]
            ],
            'linkType' => 'NETPAY_CHECKOUT'
        ];
        $headers = [
            'Accept'=> 'application/json',
            'Authorization' => 'sk_netpay_MVdIgYbEdsTJngVCvuNyTwsQZknisxJjJZWBesUndPhBv'
        ];

        $queryParams = "";

        $response = $client->request($method, $requestUrl,  [
            'json' => $formParams,
            'headers' => $headers,
            'verify' => base_path('cacert.pem')
        ]);

        $response = $response->getBody()->getContents();

        return json_decode($response)->{'hostedCheckoutUrl'};
    }
}
