<?php

namespace App\Http\Requests;

use App\Enums\StatusType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UrlResquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            //
            'original_url' => ['required', 'max:255', 'string'],
            'status' => ['nullable','string',Rule::in(StatusType::toArray())],
            
        ];
    }
}
