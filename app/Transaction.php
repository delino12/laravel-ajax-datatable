<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaction extends Model
{
    /*
    |---------------------------------------------
    | GET ALL TRANSACTIONS
    |---------------------------------------------
    */
    public function getAllTransactions(){
    	$transactions = Transaction::orderBy('id', 'DESC')->get();
    	$trans_box = [];
    	if(count($transactions) > 0){
    		foreach ($transactions as $tl) {
    			$user = User::where('id', $tl->user_id)->first();
    			if($user !== null){
    				$data = [
    					'id' 			=> $tl->id,
    					'name' 			=> $user->name,
    					'email' 		=> $user->email,
    					'description' 	=> $tl->name,
    					'trans_ref'		=> $tl->ref,
    					'amount' 		=> number_format($tl->amount, 2),
    					'last_updated'  => $tl->updated_at->diffForHumans(),
    					'date' 			=> $tl->created_at->toDateTimeString(),
    				];

    				array_push($trans_box, $data);
    			}
    		}
    	}

    	// return
    	return $trans_box;
    }

	/*
	|---------------------------------------------
	| DELETE ONE TRANSACTION ID
	|---------------------------------------------
	*/
	public function deleteOneRecord($trans_id){
		// check if id is valid
		$transaction = Transaction::where("id", $trans_id)->first();
		if($transaction !== null){
			$delete_record = Transaction::find($trans_id)->delete();
			if($delete_record == true){
				$data = [
					'status' 	=> 'success',
					'message' 	=> 'Deleted!',
				];
			}else{
				$data = [
					'status' 	=> 'error',
					'message' 	=> 'Failed to delete record!',
				];
			}
		}else{
			$data = [
				'status' 	=> 'error',
				'message' 	=> 'Could not find record!',
			];
		}

		// return data
		return $data;
	}
}
