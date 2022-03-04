<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create(Request $request): Model|LoyaltyAccount
    {
        return LoyaltyAccount::create($request->all());
    }

    public function activate($type, $id): JsonResponse
    {
        if (!$account = LoyaltyAccount::where($type, $id)->first()) {
            return response()->json(['message' => 'Account is not found'], 400);
        }
        if (!$account->active) {
            $account->update(['active' => true]);
            $account->notify();
        }
        return response()->json(['success' => true]);
    }

    public function deactivate($type, $id): JsonResponse
    {
        if (!$account = LoyaltyAccount::where($type, $id)->first()) {
            return response()->json(['message' => 'Account is not found'], 400);
        }
        if ($account->active) {
            $account->update(['active' => false]);
            $account->notify();
        }
        return response()->json(['success' => true]);
    }

    public function balance($type, $id): JsonResponse
    {
        if ($account = LoyaltyAccount::where($type, $id)->first()) {
            return response()->json(['balance' => $account->getBalance()], 400);
        } else {
            return response()->json(['message' => 'Account is not found'], 400);
        }
    }
}
