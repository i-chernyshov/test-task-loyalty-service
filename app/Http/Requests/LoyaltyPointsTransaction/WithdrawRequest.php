<?php

namespace App\Http\Requests\LoyaltyPointsTransaction;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[ArrayShape([
        'account_type' => "string",
        'account_id' => "string",
        'points_amount' => "string",
        'description' => "string",
    ])]
    public function rules(): array
    {
        return [
            'account_type' => 'required|string|in:phone,card,email',
            'account_id' => 'required|string',
            'points_amount' => 'numeric',
            'description' => 'string',
        ];
    }
}
