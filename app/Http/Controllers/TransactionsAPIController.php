<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserTransactionCategory as UserTransactionCategory;
use Auth;

class TransactionsAPIController extends Controller
{
    public function user_categories() {

    	try {

    		return UserTransactionCategory::where('user_id', Auth::user()->id)->orderBy('title', 'asc')->get();

    	} catch (\Exception $e) {
    		
    		return response('Error!  Could not fetch user transaction categories.', 400);

    	}

    }
}
