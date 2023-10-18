<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function generateAccessToken(){
        $consumer_key ="HXpHgW8VMHu87gLdwRKGQz1c3GGom1O3";
        $consumer_secret = "banxci2dMRQfmqCk";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
        $curl_response = curl_exec($curl);
  
        $access_token = json_decode($curl_response);

        return $access_token->access_token;
    }

    // public function generateAccessToken1(){

    //     $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer cFJZcjZ6anEwaThMMXp6d1FETUxwWkIzeVBDa2hNc2M6UmYyMkJmWm9nMHFRR2xWOQ==']);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     echo $response;
    // }

}
