<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

use App\UserTransactionCategory;

// Requests
use App\Http\Requests\SaveTransactionRequest;
use App\Http\Requests\SaveTransactionCategoryRequest;

use Auth;
use Carbon\Carbon;



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

    		return response(['message' => 'Your transaction has been saved!'], 201);

    	} catch (\Exception $e) {
    		
    		return response([
    			'msg' => 'Error!  We could not save your transaction.',
    			'e' => $e,
    			'postData' => $postData
    		], 400);

    	}

    }

    public function saveTransactionCategory(SaveTransactionCategoryRequest $request) {

        try {
            
            $postData = $request->all();

            $postData['user_id'] = Auth::user()->id;

            $transactionCategory = new UserTransactionCategory();
            $transactionCategory->create($postData);

            return response(['message' => 'Your category has been saved!'], 201);

        } catch (\Exception $e) {
            
            return response([
                'message' => 'Error!  We could not save your transaction category.',
                'e' => $e,
                'postData' => $postData
            ], 400);

        }

    }

    public function deleteTransactionCategory($category_id) {

        try {

            // Note: Only delete the category if it isn't being used.
            
            $transactions = Transaction::where('category_id', $category_id)->first();

            if(!$transactions) {

                $transactionCategory = UserTransactionCategory::where('id', $category_id)
                ->where('user_id', Auth::user()->id)->delete();   

                return response(['message' => 'Your category has been deleted.'], 200);

            } else {

                return response(['message' => 'Cannot delete a category that has assocaited transactions.'], 400);

            }

        } catch (\Exception $e) {
            
             return response([
                'message' => 'Error!  We could not delete your transaction category.',
                'e' => $e
            ], 400);

        }

    }

    public function get_all_transactions(Request $post) {

    	try {
    		
    		$transactions = Transaction::query();

	    	$transactions->where('user_id', Auth::user()->id)
	    		->with('UserTransactionCategory')
	    		->orderBy('date', 'desc');

	    	return $transactions->paginate(10);

    	} catch (\Exception $e) {
    		
    		return response([
    			'message' => 'Error!  We could not save your transaction.',
    			'e' => $e,
    			//'postData' => $postData
    		], 400);

    	}

    	

    }

    public function get_recent_transactions($type = null) {

    	try {
    		
    		$recent_out = Transaction::where('type_id', -1)
    			->where('user_id', Auth::user()->id)
    			->with('UserTransactionCategory')
    			->orderBy('date', 'desc')->limit(5)->get()->toArray();

    		$recent_in = Transaction::where('type_id', 1)
    			->where('user_id', Auth::user()->id)
    			->with('UserTransactionCategory')
    			->orderBy('date', 'desc')->limit(5)->get()->toArray();

    		switch ($type) {
    			case 'in':
    				return $recent_in;
    				break;
    			case 'out':
    				return $recent_out;
    				break;
    			default:
    				return [
    					'in' => $recent_in,
		    			'out' => $recent_out
		    		];
    				break;
    		}

    	} catch (\Exception $e) {
    		
    		return response(['message' => 'Error! We could not fetch your recent transactions.'], 400);

    	}

    }
}
