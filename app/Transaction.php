<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Transaction extends Model
{
   

    protected $fillable = [

        'amount', 'transaction_name', 'status', 'user_id',
    ];


protected $hidden = ['created_at', 'updated_at'];



    public function user()
    {
        return $this->belongsTo('App\User');
    }







}
