<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // ACCESS TOKEN. 
    public function token(){
        $consumerKey='oMjXG7tkWAq9HrO8EOflNpOLG7eZPS4E';
        $consumerSecret='et0xLskpAGOGUEUL';
        $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response=Http::withBasicAuth($consumerKey,$consumerSecret)->get($url);
        return $response['access_token'];
    }
}
