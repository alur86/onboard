<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Order extends Model
{
    
  
protected $fillable = [

      'location_id', 'order_name', 'order_amount', 
  ];



protected $hidden = ['created_at', 'updated_at'];



 public $timestamps = true;	
    
 protected $table = 'orders';


public function locations(){
	
        return $this->hasMany('App\Location');
    }


public static function makeorder($amount,$location_id= null) {


        DB::beginTransaction();

        try {

            $order = new \App\Order();
            $order->order_amount = $amount;
            $order->order_name= Str::random();
            $order->location_id = $location_id;
            $order->created_at =  date("Y-m-d H:i:s");
            $order->save();


          DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        
     }




}
