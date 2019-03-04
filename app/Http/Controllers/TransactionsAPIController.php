<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction as Transaction;
use App\UserTransactionCategory as UserTransactionCategory;
use Auth;
use Carbon\Carbon;

// Requests
use App\Http\Requests\SaveTransactionRequest;

class TransactionsAPIController extends Controller
{
    public function user_categories() {

    	try {
    		$moneyOut = UserTransactionCategory::where('user_id', Auth::user()->id)
    			->where('type_id', -1)
    			->orderBy('title', 'asc')->get()->toArray();

    		$moneyIn = UserTransactionCategory::where('user_id', Auth::user()->id)
    			->where('type_id', 1)
    			->orderBy('title', 'asc')->get()->toArray();
    		return [
    			'out' => $moneyOut,
    			'in' => $moneyIn
    		];

    	} catch (\Exception $e) {
    		
    		return response(['message' => 'Error!  Could not fetch user transaction categories.'], 400);

    	}

    }

    public function save(SaveTransactionRequest $request) {

    	try {
    		
    		$postData = $request->all();

    		$transaction = new Transaction();

    		$postData['user_id'] = Auth::user()->id;
    		$postData['date'] = Carbon::parse($postData['date'])->format('Y-m-d');

    		$transaction->create($postData);

    		return response(['message' => 'Awesome! Your transaction has been saved!'], 201);

    	} catch (\Exception $e) {
    		
    		return response([
    			'msg' => 'Error!  We couldn\'t save your transaction.',
    			'e' => $e,
    			'postData' => $postData
    		], 400);

    	}

    }
}
