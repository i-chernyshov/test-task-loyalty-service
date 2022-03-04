<?php

namespace App\Features\LoyaltyPointsTransaction\Deposit;

use App\Features\LoyaltyPointsTransaction\LoyaltyPointsTransactionProcess;
use App\Mail\LoyaltyPointsReceived;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use function response;

class TransactionDepositProcess extends LoyaltyPointsTransactionProcess
{
    protected function store(): Model|LoyaltyPointsTransaction|null
    {
        return $this->object ? LoyaltyPointsTransaction::create(array_merge([
            'account_id' => $this->object->id,
        ], (array)$this->dto)) : null;
    }

    public function run(array $args): Model|JsonResponse|LoyaltyPointsTransaction
    {
        $this->dto = new TransactionDepositDTO($args);
        $transaction = $this->checkAccount($args['account_type'], $args['account_id'])
            ->store();
        if ($transaction) {
            Log::info($transaction);
            $this->notify($transaction);
            return $transaction;
        } else {
            return response()->json(['message' => $this->message], 400);
        }
    }

    private function notify(LoyaltyPointsTransaction $transaction)
    {
        if ($this->object->email != '' && $this->object->email_notification) {
            Mail::to($this->object)->send(
                new LoyaltyPointsReceived($transaction->points_amount, $this->object->getBalance())
            );
        }
        if ($this->object->phone != '' && $this->object->phone_notification) {
            Log::info(
                "You received $transaction->points_amount. Your balance {$this->object->getBalance()}."
            );
        }
    }
}
