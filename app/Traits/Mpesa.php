<?php

namespace App\Traits;

use Illuminate\Http\Request;
use URL;
use Carbon\Carbon;
trait Mpesa
{
	protected $api_url = 'https://api.safaricom.co.ke';
	protected $shortcode;
	protected $passkey;
	protected $type;
	protected $consumer_key;
	protected $consumer_secret;

	public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($this->shortcode.$this->passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }

    public function generateAccessToken()
    {
        $credentials = base64_encode($this->consumer_key.":".$this->consumer_secret);
        $url = $this->api_url."/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }

    public function STKPush($type, $amount, $phone, $callback, $reference, $narrative)
    {
        $url = $this->api_url.'/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));
        $phone = '254'.substr($phone, -9);
        $curl_post_data = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => ($type='Paybill')?'CustomerPayBillOnline':'CustomerBuyGoodsOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $callback,
            'AccountReference' => $reference,
            'TransactionDesc' => $narrative,
        ];
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return $curl_response;
    }

    public function mpesaRegisterUrls($confirmationURL, $validationURL)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->api_url.'/mpesa/c2b/v1/registerurl');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '. $this->generateAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'ShortCode' => config('app.mpesa_shortcode'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $confirmationURL,
            'ValidationURL' => $validationURL,
        )));
        $curl_response = curl_exec($curl);
        echo $curl_response;
    }

}