<?php

namespace App\Features\LoyaltyPointsTransaction\Cancel;

class TransactionCancelDTO
{
    public string $cancellation_reason;
    public int $canceled;

    public function __construct(array $args)
    {
        $this->cancellation_reason = $args['cancellation_reason'];
        $this->canceled = time();
    }
}
