<?php

namespace App\Features\LoyaltyPointsTransaction\Cancel;

use App\Features\LoyaltyPointsTransaction\LoyaltyPointsTransactionProcess;
use Illuminate\Http\JsonResponse;
use function response;

class TransactionCancelProcess extends LoyaltyPointsTransactionProcess
{
    protected function store()
    {
        $this->object?->update((array)$this->dto);
    }

    public function run(array $args): JsonResponse
    {
        $this->dto = new TransactionCancelDTO($args);
        $this->checkTransaction($args['transaction_id'])->store();
        if ($this->object) {
            return response()->json(['message' => 'Transaction cancelled']);
        } else {
            return response()->json(['message' => $this->message]);
        }
    }
}
