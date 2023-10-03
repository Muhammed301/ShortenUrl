<?php

namespace App\Actions;

use stdClass;
use App\Models\Url;
use App\Enums\PaymentTypeEnum;
use App\Actions\ShortenUrlHelper;
use App\Sourcery\PaystackPayment;
use App\Sourcery\FlutterwavePayment;
use Illuminate\Support\Facades\Auth;
use App\DataObjectTransfer\PaymentData;

class PaymentAction 
{
    public function __construct(
        public PaystackPayment $paystackPayment,
        public FlutterwavePayment $flutterwavePayment,
        public Auth $user
    
    ) {
    }
    
    public function execute(PaymentData $urlData){
            $user = $this->user::user();
             if($urlData->paymentMethod == PaymentTypeEnum::PAYSTACK){
               $response= $this->paystackPayment->initiate($urlData->amount,$user);
                return $response;

             }elseif($urlData->paymentMethod == PaymentTypeEnum::FLUTTERWAVE){
                $response= $this->flutterwavePayment->initiate($urlData->amount,$user);
                return $response;
             }
    
        
    }
}
