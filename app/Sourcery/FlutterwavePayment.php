<?php

namespace App\Sourcery;

use App\Models\Url;
use App\Actions\ShortenUrlHelper;
use Illuminate\Support\Facades\Auth;

class FlutterwavePayment 
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
        $this->public_key =  config('services.flutterwave.key');
        $this->secret_key =  config('services.flutterwave.secret');
        $this->base_url =  config('services.flutterwave.url');
    }
    
    public function initiate($data,$user){

        $url =$this->base_url."payments";
        
      

        $fields = [
            'amount' => $data,
            'currency' => 'NGN',
            'tx_ref' => time(),
            'redirect_url' => route('payment.callback'),
            'payment_options' => "card",
            'customer' => [
                'email' => $user->email,
                // 'phonenumber' => 998776666,
                'name' => $this->user::user()->first_name
            ],
            'customizations' => [
                "title" => "Fund Your Wallet",
                "description" => 'testing',
                // "logo" => $this->logo_url
            ]
        ];
      
        $fields_string = json_encode($fields);
        // dd($fields_string);
      
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_ENCODING,'');
        curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch,CURLOPT_TIMEOUT, 0);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // curl_setopt($ch,CURLOPT_CUSTOMREQUEST, );
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ". config('services.flutterwave.secret'),
            'Content-Type:application/json',
            // "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $res = json_decode(curl_exec($ch));
        curl_close($ch);

        return $res;
    
        
    }

    public function verify_payment($reference){
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->base_url."transactions/". $reference."/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". $this->secret_key,
            "Cache-Control: no-cache",
        ),
        ));

        
        $response = curl_exec($curl);

        curl_close($curl);

        
        return $response;
        
    }
}