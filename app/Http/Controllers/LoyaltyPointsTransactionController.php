<?php

namespace App\Http\Controllers;

use App\Features\LoyaltyPointsTransaction\TransactionMethodFactory;
use App\Http\Requests\LoyaltyPointsTransaction\CancelRequest;
use App\Http\Requests\LoyaltyPointsTransaction\DepositRequest;
use App\Http\Requests\LoyaltyPointsTransaction\WithdrawRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class LoyaltyPointsTransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function deposit(DepositRequest $request)
    {
        Log::info('Deposit transaction input: ' . print_r($request->all(), true));
        return TransactionMethodFactory::getTransactionMethod('deposit')->run($request->validated());
    }

    /**
     * @throws Exception
     */
    public function cancel(CancelRequest $request)
    {
        Log::info('Cancel transaction input: ' . print_r($request->all(), true));
        return TransactionMethodFactory::getTransactionMethod('cancel')->run($request->validated());
    }

    /**
     * @throws Exception
     */
    public function withdraw(WithdrawRequest $request)
    {
        Log::info('Withdraw transaction input: ' . print_r($request->all(), true));
        return TransactionMethodFactory::getTransactionMethod('withdraw')->run($request->validated());

    }
}
