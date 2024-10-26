<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public static function SendMessage($Recipient, $Message) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $Recipient,
                'message' => $Message,
                'url' => '',
                'filename' => '',
                'schedule' => '0',
                'typing' => true,
                'delay' => '300-600',
                'countryCode' => '62',
                'file' => '',
                'location' => ''
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . config('app.fonte_token'),
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $response = curl_error($curl);
            // Handle the error message
        } 

        curl_close($curl);
        
        return $response;
    }
}
