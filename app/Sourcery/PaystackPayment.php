<?php

namespace App\Sourcery;

use Illuminate\Support\Facades\Auth;

class PaystackPayment
{
    /**
     * paystack api key
     *
     * @var string
     */
    protected $public_key;

    /**
     * paystack secret key
     *
     * @var string
     */
    protected $secret_key;

    /**
     * paystack base_url
     *
     * @var string
     */
    protected $base_url;
    //
    public function __construct(public Auth $user) {
        $this->public_key =  config('services.paystack.key');
        $this->secret_key =  config('services.paystack.secret');
        $this->base_url =  config('services.paystack.url');
    }
    
    public function initiate($data,$user){

        $url =$this->base_url."transaction/initialize";
        
        $fields = [
          'email' => $user->email,
          'amount' => $data * 100,
          'currency'=>'NGN',
          'callback_url'=> route('payment.callback'),
        ];

             
        $fields_string = http_build_query($fields);
      
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ". $this->secret_key,
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        //execute post
        $response = json_decode(curl_exec($ch));

        return $response;
    
        
    }

    public function verify_payment($reference){
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
        CURLOPT_URL => config('services.paystack.url')."transaction/verify/". $reference,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". config('services.paystack.secret'),
            "Cache-Control: no-cache",
        ),
        ));

        
        $response = curl_exec($curl);
        curl_close($curl);
        
        
        return $response;
        
    }
}