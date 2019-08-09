<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function generateToken(){
        $consumer_key=env('MPESA_CONSUMER_KEY');
        $consumer_secret=env('MPESA_CONSUMER_SECRET');
        $mpesa_env=env('MPESA_ENV');
        if(!$consumer_key || !$consumer_secret){
            echo 'No consumer key or consumer secret is defined in the .env file';
        }
        else{
            if ($mpesa_env=='sandbox'){
                $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            }
            elseif ($mpesa_env=='live'){
                $url='https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            }
            else{
                echo 'Mpesa environment is undefined in .env file. Set your environment as either sandbox or live';
            }
            $curl=curl_init();
            curl_setopt($curl,CURLOPT_URL,$url);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode($consumer_key.':'.$consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $curl_response = curl_exec($curl);

            return json_decode($curl_response)->access_token;


        }




    }

    public function sendMoney(Request $request){
        $BusinessShortCode=174379;
        $Passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType='CustomerPayBillOnline';
        $Amount=$request->get('amount');
        $PartyA=$request->get('phone');
        $PartyB=174379;
        $PhoneNumber=$request->get('phone');
        $CallBackURL='http://herihomes.vinehub.co.ke/api/transactions';
        $AccountReference='Heri Home Testing';
        $TransactionDesc='Testing';


        $mpesa_env=env('MPESA_ENV');
        dd($mpesa_env);
        if($mpesa_env=='sandbox'){
            $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        elseif ($mpesa_env=='live'){
            $url='https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        else{
            return json_encode(['error message'=>'invalid mpesa environment']);
        }
        $access_token=self::generateToken();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values

            'BusinessShortCode' => $BusinessShortCode,
            'Password' => base64_encode($BusinessShortCode.$Passkey.date("YmdHis")),
            'Timestamp' =>date("YmdHis"),
            'TransactionType' => $TransactionType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'PhoneNumber' => $PhoneNumber,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc,
        );
        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        return $curl_response;




    }

    public function transaction_logs(Request $request){

    }
}
