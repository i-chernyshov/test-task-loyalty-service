<?php

namespace App\Features\LoyaltyPointsTransaction\Withdraw;

class TransactionWithdrawDTO
{
    public string $points_rule;
    public float $points_amount;
    public string $description;

    public function __construct(array $args)
    {
        $this->points_rule = 'withdraw';
        $this->points_amount = $args['points_amount'];
        $this->description = $args['description'];
    }
}
