<?php

namespace App\Http\Requests\LoyaltyPointsTransaction;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CancelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'cancellation_reason' => "string",
        'transaction_id' => "string"
    ])]
    public function rules(): array
    {
        return [
            'cancellation_reason' => 'required|string',
            'transaction_id' => 'required|numeric',
        ];
    }
}
