<?php

namespace App\Http\Controllers;

use App\Order;
use App\PaymentType;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class NetPayController extends Controller
{
    protected $baseUrl;
    protected $secretKey;
    protected $verifySSL;

    public function __construct() {
        if(config('netpay.mode') == 'live'){
            $this->baseUrl = config('netpay.live.base_url');
            $this->secretKey = config('netpay.live.secret_key');
            $this->verifySSL = true;
        }
        else{
            $this->baseUrl = config('netpay.sandbox.base_url');
            $this->secretKey = config('netpay.sandbox.secret_key');
            $this->verifySSL = base_path('cacert.pem');
        }

    }

    public function netpayIntentPay(Request $request, User $user)
    {
        $client = new Client([]);//COMENTARIO

        $monthCount = 0;

        if($request->cardType == 'credit'){
            $monthCount = 6;
        }

        // "installments" => [
        //     "plan" => [
        //         "count" => 3,
        //         "interval"=> "month"
        //     ]
        // ],

        $method = 'POST';
        $requestUrl = $this->baseUrl.'v3/charges';
        $formParams = [
            'amount' => $request->amount,
            'description' => $request->order,
            'paymentMethod' => 'card',
            'currency' => 'MXN',
            "installments" => [
                "plan" => [
                    "count" => $monthCount,
                    "interval"=> "month"
                ]
            ],
            'billing' => [
                'firstName' => $user->name,
                'lastName' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => [
                    'city' => $user->city,
                    'country' => 'MX',
                    'postalCode' => $user->zip_code,
                    'state' => $user->state,
                    'street1' => $user->ship_address,
                    'street2' => $user->second_ship_address
                ]
            ],
            'redirect3dsUri' => 'http://127.0.0.1:8000/dashboard/lists/ordenes',
            'client' => [
                'id' => $user->netpayClientId
            ],
            'cvv' => $request->cvv,
            'saveCard' => 'true',
            'source' => $request->token

        ];
        $headers = [
            'Accept'=> 'application/json',
            'Authorization' => $this->secretKey,
            'Content-Type' => 'application/json',
            'User-Agent' => 'ReadMe-API-Explorer'
        ];

        $response = $client->request($method, $requestUrl, [
            'json' => $formParams,
            'headers' => $headers,
            'verify' => $this->verifySSL
        ]);

        $response = $response->getBody()->getContents();
        $status = json_decode($response)->{'status'};
        if($status == 'success'){
            $newOrder = Order::find($request->idOrder);
            $newOrder->state = 'Recibida';
            $newOrder->save();
        }
        return $status;
    }

    public function saveClient(Request $request, User $user)
    {
        $client = new Client([]);

        $method = 'POST';
        $requestUrl = $this->baseUrl.'v3/clients';

        $formParams = [
            'firstName' => $user->name,
            'lastName' => $user->last_name,
            'phone' => $user->phone,
            'email' => $user->email,
            'paymentSource' => [
                'source' => $request->token,
                'type' => 'card'
            ],
            'identifier' => 'client-'.$user->id
        ];
        $headers = [
            'Accept' => 'application/json',
            'secretkey'=> $this->secretKey,
            'Content-Type' => 'application/json',
            'Authorization' => $this->secretKey,
            'User-Agent' => 'ReadMe-API-Explorer'

        ];

        $response = $client->request($method, $requestUrl,  [
            'json' => $formParams,
            'headers' => $headers,
            'verify' => $this->verifySSL
        ]);

        $response = $response->getBody()->getContents();

        $user->netpayClientId =  json_decode($response)->{'id'};
        $user->save();
        if(!$user->paymentTypes->contains('name', 'NetPay')){
            $id = PaymentType::where('name', 'NetPay')->first()->id;
            $user->paymentTypes()->attach($id);
        }
    }

    public function getClient(User $user)
    {
        // dd(env('NETPAY_SECRET_KEY_SBOX'));
        $client = new Client([]);

        $method = 'GET';
        $requestUrl = $this->baseUrl.'v3/clients/'.$user->netpayClientId;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => $this->secretKey,
            'Content-Type' => 'application/json',
            'User-Agent' => 'ReadMe-API-Explorer'
        ];

        $response = $client->request($method, $requestUrl,  [
            'headers' => $headers,
            'verify' => $this->verifySSL
        ]);

        $response = $response->getBody()->getContents();
        return $response;
    }

    public function addCard(Request $request, User $user)
    {
        $client = new Client([]);

        $method = 'PUT';
        $requestUrl = $this->baseUrl.'v3/clients/'.$user->netpayClientId.'/token';

        $formParams = [
            'token' => $request->token,
            'preAuth' => true,
            'cvv2' => $request->cvv2
        ];
        $headers = [
            'Accept' => 'application/json',
            'secretkey'=> $this->secretKey,
            'Content-Type' => 'application/json',
            'Authorization' => $this->secretKey,
            'User-Agent' => 'ReadMe-API-Explorer'

        ];

        $response = $client->request($method, $requestUrl,  [
            'json' => $formParams,
            'headers' => $headers,
            'verify' => $this->verifySSL
        ]);

        $response = $response->getBody()->getContents();
    }

    public function deleteCard(Request $request, User $user)
    {
        $client = new Client([]);

        $method = "DELETE";
        $requestUrl = $this->baseUrl.'v3/clients/'.$user->netpayClientId.'/token/'.$request->token;

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->secretKey,
            'User-Agent' => 'ReadMe-API-Explorer'
        ];

        $response = $client->request($method, $requestUrl,  [
            'headers' => $headers,
            'verify' => $this->verifySSL
        ]);

        $response = $response->getBody()->getContents();
    }
}
