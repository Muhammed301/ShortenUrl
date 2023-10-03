<?php
namespace App\DataObjectTransfer;

use App\Enums\PaymentTypeEnum;
use App\Http\Requests\PaymentRequest;
use Ramsey\Uuid\Type\Integer;

class PaymentData{

    public function __construct(
        public readonly ?int $amount,
        public readonly ?string $paymentMethod,
    )
    { }

    public static function FormRequest(PaymentRequest $request) :self{
        return new static(
            $request->input('amount'),
            $request->input('paymentMethod') ,

        );

    }
}