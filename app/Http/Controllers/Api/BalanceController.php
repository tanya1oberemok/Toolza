<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BalanceResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController as BaseController;

class BalanceController extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function index(int $user_id): JsonResponse
    {
        $user = User::query()->find($user_id);
        if(is_null($user)){
            return $this->sendError('User id not found!');
        }

        $transactions = Transaction::query()
            ->where('user_id', $user_id)
            ->get()
            ->groupBy('type');

        $deposit = $transactions['deposit']->sum('amount');
        $withdrawal = $transactions['withdrawal']->sum('amount');

        return $this->sendResponse(BalanceResource::collection([$deposit - $withdrawal]));
    }
}
