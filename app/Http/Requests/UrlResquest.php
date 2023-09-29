<?php

namespace App\Http\Requests;

use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
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
            // 'status' => ['nullable', 'string', Status::class, 'default:'. Status::Active],
            'status' => ['nullable','string',new EnumValue(Status::class)],
            
        ];
    }
}
