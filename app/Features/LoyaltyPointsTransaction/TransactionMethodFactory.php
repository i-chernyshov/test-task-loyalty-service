<?php

namespace App\Features\LoyaltyPointsTransaction;

use App\Features\LoyaltyPointsTransaction\Cancel\TransactionCancelProcess;
use App\Features\LoyaltyPointsTransaction\Withdraw\TransactionWithdrawProcess;
use App\Features\LoyaltyPointsTransaction\Deposit\TransactionDepositProcess;
use Exception;

class TransactionMethodFactory
{
    /**
     * @throws Exception
     */
    public static function getTransactionMethod(string $action): LoyaltyPointsTransactionProcess
    {
        return match ($action) {
            'deposit' => new TransactionDepositProcess(),
            'cancel' => new TransactionCancelProcess(),
            'withdraw' => new TransactionWithdrawProcess(),
            default => throw new Exception('Unknown transaction method'),
        };
    }
}
