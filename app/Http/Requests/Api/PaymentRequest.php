<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_id' => 'required|string|max:255',
            'status' => ['required', Rule::enum(PaymentStatusEnum::class)],
            'amount' => 'required|integer|min:0',
            'event_time' => 'required|date',
        ];
    }
}
