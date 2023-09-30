<?php
namespace App\DataObjectTransfer;

use App\Enums\StatusType;
use App\Http\Requests\UrlResquest;

class UrlData{

    public function __construct(
        public readonly string $url,
        public readonly ?string $status,
    )
    { }

    public static function FormRequest(UrlResquest $request) :self{
        return new static(
            $request->input('original_url'),
            $request->input('status') ?? StatusType::ACTIVE,

        );

    }
}