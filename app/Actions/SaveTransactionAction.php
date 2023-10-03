<?php

namespace App\Actions;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SaveTransactionAction 
{
    public function __construct( ) {
    }
    
    public function execute( $paymentData,Transaction $transaction): Transaction{

            $transaction->reference =$paymentData->reference ?? $paymentData->id;
            $transaction->amount = $paymentData->amount;
            $transaction->status = $paymentData->status; 
            $transaction->user_id = Auth::user()->id;   
            $transaction->currency = $paymentData->currency;  

    
            $transaction->save();
            return  $transaction;
    
        
    }
}
