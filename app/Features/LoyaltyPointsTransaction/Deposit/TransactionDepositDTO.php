<?php

namespace App\Features\LoyaltyPointsTransaction\Deposit;

use App\Models\LoyaltyPointsRule;

class TransactionDepositDTO
{
    public int|null $points_rule = null;
    public float $points_amount = 0;
    public string $description;
    public int $payment_id;
    public float $payment_amount;
    public int $payment_time;

    public function __construct(array $args)
    {
        if ($pointsRule = LoyaltyPointsRule::where('points_rule', $args['loyalty_points_rule'])->first()) {
            $this->points_rule = $pointsRule->id;
            $this->points_amount = match ($pointsRule->accrual_type) {
                LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE => ($args['payment_amount'] / 100) *
                    $pointsRule->accrual_value,
                LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT => $pointsRule->accrual_value
            };
        }
        $this->description = $args['description'];
        $this->payment_id = $args['payment_id'];
        $this->payment_amount = $args['payment_amount'];
        $this->payment_time = $args['payment_time'];
    }
}
