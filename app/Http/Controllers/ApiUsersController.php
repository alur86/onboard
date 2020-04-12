<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class ApiUsersController extends Controller {
    

 public function __construct()
    {
        $this->middleware('auth');
    }



public function store(Request $request){

   $payments = Validator::make($req->all(), [

            'ammount' => 'required|numeric|min:2|max:10',
            'account_from' => 'required|min:5|max:60',
            'account_to' => 'required|min:5|max:60',
        ]);

        if ($payments->passes()) {

        	$amount=floatval($req->post('amount'));
        	$account_from=$req->post('account_from');
        	$account_to=$req->post('account_to');

            $withdraw_money = \App\User::withdraw($amount,$account_from, $account_to);

           return response()->json($withdraw_money, 200);
    }

    else {

         return redirect()->back();
  
    }


 }









}
