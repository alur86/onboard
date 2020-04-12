<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','account', 'ammount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function transactions(){

        return $this->hasMany('App\Transaction');
    }

   
   public function locations(){

        return $this->hasMany('App\Location');
    }


     
   public function shipments(){

        return $this->hasMany('App\Shipment');
    }





    public function deposit($amount) {


       $user = $this;

        DB::beginTransaction();

        try {

            $transaction = new \App\Transaction();
            $transaction->user_id = $user->id;
            $transaction->transaction_name = Str::random();
            $transaction->amount = $amount;
            $transaction->ballance += $amount;
            $transaction->status = 'done';
            $transaction->account_id = $user->account;
            $transaction->created_at =  date("Y-m-d H:i:s");
            $transaction->save();

            DB::commit();


        } catch (\Exception $e) {

            DB::rollback();

            throw $e;
        }

        return $this;
    }


    public function getbalance($account) {
 

          $balance = \App\User::where([
            'account' => $account,
        ])->pluck('ammount')->orderBy('name', 'desc')->first();

        if (!$balance) {

            return null;
        }

        return $balance;

    }



    public function withdraw($amount,$account_from, $account_to) {

        $user = $this;


        $total=$this->getbalance($account_from);

        if ($amount > $total || $amount <= 0) {

            throw new \Exception("You can not do this transaction:wrong amount");
        }
       


        DB::beginTransaction();

        try {


            $userFrom = \App\User::where( 'account', '=', $account_from)->first();
            $userFrom->amount -= $amount;
            $userFrom->account = $account_from;
            $userFrom->updated_at =  date("Y-m-d H:i:s");
            $userFrom->save();

              
            $userTo = \App\User::where( 'account', '=', $account_to)->first();
            $userTo->amount += $amount;
            $userTo->account = $account_from;
            $userTo->updated_at =  date("Y-m-d H:i:s");
            $userTo->save();
           



        $transactionFrom = \App\Transaction()::where('user_id', '=',$userFrom)->first();
            $transactionFrom->user_id = $user->id;
            $transactionFrom->transaction_name = Str::random();
            $transactionFrom->amount = $amount; 
            $transactionFrom->ballance -= $amount;
            $transactionFrom->status = 'done';
            $transactionFrom->account_id = $account_from;
            $transactionFrom->created_at =  date("Y-m-d H:i:s");
            $transactionFrom->save();


            $transactionTo = \App\Transaction()::where( 'user_id', '=',$userTo)->first();
            $transactionTo->user_id = $user->id;
            $transactionTo->transaction_name = Str::random();
            $transactionTo->amount = $amount; 
            $transactionTo->ballance += $amount;
            $transactionTo->status = 'done';
            $transactionTo->account_id = $account_to;
            $transactionTo->created_at =  date("Y-m-d H:i:s");
            $transactionTo->save();


          DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }



}
