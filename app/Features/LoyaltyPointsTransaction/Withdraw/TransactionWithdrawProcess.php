<?php

namespace App\Features\LoyaltyPointsTransaction\Withdraw;

use App\Features\LoyaltyPointsTransaction\LoyaltyPointsTransactionProcess;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use function response;

class TransactionWithdrawProcess extends LoyaltyPointsTransactionProcess
{
    protected function store(): Model|LoyaltyPointsTransaction|null
    {
        if ($this->object) {
            if ($this->dto->points_amount <= 0) {
                return $this->resultCheckBeforeStore('Wrong loyalty points amount');
            }
            if ($this->object->getBalance() < $this->dto->points_amount) {
                return $this->resultCheckBeforeStore('Insufficient funds');
            }
            $this->dto->points_amount = -$this->dto->points_amount;
            return LoyaltyPointsTransaction::create(array_merge([
                'account_id' => $this->object->id,
            ], (array)$this->dto));
        } else {
            return null;
        }
    }

    private function resultCheckBeforeStore(string $message)
    {
        Log::info("$message: {$this->dto->points_amount}");
        $this->message = $message;
        return null;
    }

    public function run(array $args): Model|JsonResponse|LoyaltyPointsTransaction
    {
        $this->dto = new TransactionWithdrawDTO($args);
        $transaction = $this->checkAccount($args['account_type'], $args['account_id'])->store();
        if ($transaction) {
            Log::info($transaction);
            return $transaction;
        } else {
            return response()->json(['message' => $this->message], 400);
        }
    }
}
