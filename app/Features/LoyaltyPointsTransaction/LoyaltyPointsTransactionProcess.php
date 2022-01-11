<?php

namespace App\Features\LoyaltyPointsTransaction;

use App\Features\LoyaltyPointsTransaction\Cancel\TransactionCancelDTO;
use App\Features\LoyaltyPointsTransaction\Deposit\TransactionDepositDTO;
use App\Features\LoyaltyPointsTransaction\Withdraw\TransactionWithdrawDTO;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Support\Facades\Log;

abstract class LoyaltyPointsTransactionProcess
{
    protected LoyaltyAccount|LoyaltyPointsTransaction|null $object = null;
    protected TransactionDepositDTO|TransactionCancelDTO|TransactionWithdrawDTO $dto;
    protected string $message = '';

    protected function checkAccount(string $type, string $id): LoyaltyPointsTransactionProcess
    {
        $account = LoyaltyAccount::where($type, $id)->first();
        if (!$account) {
            $this->message = 'Account is not found';
            Log::info($this->message);
        } else if (!$account->active) {
            $this->message = 'Account is not active';
            Log::info($this->message);
        } else {
            $this->object = $account;
        }
        return $this;
    }

    protected function checkTransaction(int $id): LoyaltyPointsTransactionProcess
    {
        $transaction = LoyaltyPointsTransaction::where('id', $id)
            ->where('canceled', '=', 0)
            ->first();
        if (!$transaction) {
            $this->message = 'Transaction is not found';
            Log::info($this->message);
        } else {
            $this->object = $transaction;
        }
        return $this;
    }

    abstract protected function store();

    abstract public function run(array $args);
}
