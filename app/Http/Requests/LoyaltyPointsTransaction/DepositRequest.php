<?php

namespace App\Http\Requests\LoyaltyPointsTransaction;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class DepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'account_type' => "string",
        'account_id' => "string",
        'loyalty_points_rule' => "string",
        'description' => "string",
        'payment_id' => "string",
        'payment_amount' => "string",
        'payment_time' => "string"
    ])]
    public function rules(): array
    {
        return [
            'account_type' => 'required|string|in:phone,card,email',
            'account_id' => 'required|string',
            'loyalty_points_rule' => 'string',
            'description' => 'string',
            'payment_id' => 'string',
            'payment_amount' => 'numeric',
            'payment_time' => 'integer',
        ];
    }
}
