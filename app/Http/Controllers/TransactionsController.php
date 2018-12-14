<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionsController extends Controller
{
    /*
    |---------------------------------------------
    | LOAD ALL TRANSACTIONS
    |---------------------------------------------
    */
    public function loadAll(){
    	$transactions 	= new Transaction();
    	$data 			= $transactions->getAllTransactions();

    	// return response
    	return response()->json($data);
    }

    /*
    |---------------------------------------------
    | DELETE ONE
    |---------------------------------------------
    */
    public function deleteOne(Request $request){
    	$transactions 	= new Transaction();
    	$data 			= $transactions->deleteOneRecord($request->transid);

    	// return response
    	return response()->json($data);
    }
}
