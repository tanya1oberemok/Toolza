<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionPaginateResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $transactionQuery = Transaction::query();

        if (
            is_array($filters)
            && array_key_exists('type', $filters)
            && in_array($filters['type'], ['deposit', 'withdrawal'])
        ) {
            $transactionQuery->where('type', $filters['type']);
        }

        if (
            is_array($filters)
            && array_key_exists('type', $filters)
            && in_array($filters['type'], ['deposit', 'withdrawal'])
        ) {
            $transactionQuery->where('type', $filters['type']);
        }

        if (
            is_array($filters)
            && array_key_exists('from_date', $filters)
            && array_key_exists('to_date', $filters)
        ) {
            $transactionQuery->whereBetween('created_at', [$filters['from_date'], $filters['to_date']]);
        }

        $transactions = $transactionQuery->with('user')
            ->orderBy('created_at')
            ->paginate(10, ['*'], 'page', $request['page']);

        return $this->sendResponse(new TransactionPaginateResource($transactions));
    }

    /**
     * @return JsonResponse
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        $transaction = Transaction::create($request->all());

        return $this->sendResponse(new TransactionResource($transaction));
    }
}
