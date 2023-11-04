<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Actions\PaymentAction;
use App\Enums\PaymentTypeEnum;
use App\Sourcery\PaystackPayment;
use App\Sourcery\FlutterwavePayment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use App\Actions\SaveTransactionAction;
use App\Actions\SaveUserAction;
use App\DataObjectTransfer\PaymentData;

class PaymentController extends Controller
{

    //
    public function __construct(
        public PaymentAction $paymentAction,
        public PaystackPayment $paystackPayment,
        public FlutterwavePayment $flutterwavePayment,
        public SaveTransactionAction  $saveTransactionAction,
        public SaveUserAction  $saveUserAction
    ) {
       
    }

    public function index(){

        $paymentMethod= PaymentTypeEnum::toArray();
        return view('app.payment.index', compact('paymentMethod'));
    }

    /**
     * @param InitiatePaymentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function initiate(PaymentRequest $paymentRequest)
    {
        $paymentData = PaymentData::FormRequest($paymentRequest);
        
        $paymentResponse = $this->paymentAction->execute($paymentData) ;

        if($paymentResponse->status){
            // dd($paymentResponse->data->link);
            return redirect($paymentResponse->data->authorization_url ?? $paymentResponse->data->link );
        }else{
            
            return back()->withError($paymentResponse->message);
        }
       
    }  
    
    public function payment_callback(Request $request){
       
        if($request->reference ){
            
            $response = json_decode($this->paystackPayment->verify_payment($request->reference ));
        }elseif($request->transaction_id){
            $response = json_decode($this->flutterwavePayment->verify_payment($request->transaction_id));
        }

        if($response->status ?? $request->status){
            $this->saveTransactionAction->execute($response->data,new Transaction());
            $user =Auth::user();
            $data = ['wallet_balance'=>$user->wallet_balance + floatval($response->data->amount / 100)];
            $this->saveUserAction->execute($user,$data);
            return redirect()->route('index')->withSuccess('Operation Successful');
        }else{
            return back()->withError($response->message);
        }
        return view('app.payment.processing');
    }

  
}
