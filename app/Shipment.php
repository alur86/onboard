<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Shipment extends Model
{
    
  
protected $fillable = [

      'location_id', 'user_id', 'shipment_amount', 'delivered','issued',
  ];



protected $hidden = ['created_at', 'updated_at'];




 public $timestamps = true;	
    
 protected $table = 'shipments';



public function locations(){
	
        return $this->hasMany('App\Location');
    }


 public function user()
    {
        return $this->belongsTo('App\User');
    }



 public static function makeshipment($amount,$user_id = null,$location_id = null) {


        DB::beginTransaction();

        try {

            $shipment = new \App\Shipment();
            $shipment->shipment_amount = $amount;
            $shipment->user_id = $user_id;
            $shipment->location_id = $location_id;
            $shipment->created_at =  date("Y-m-d H:i:s");
            $shipment->save();


          DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        
     }




  public static function checkshipment($user_id=null) {


       $shipment = App\Shipment::where([
            'user_id' => $user_id,
        ])->andWhere([
            'delivered' => true,
        ])->andWhere([
            'issued' => true,
        ])->andWhere([
            'ammount','>',0,
        ])->orderBy('user_id', 'desc')->first();

        if (count($shipment) >0 ) {

            return true;
        }

        return false;
        
     }



public static function checkshipmentdelivery($user_id=null) {

            $delivery = \App\Shipment::where( 'user_id', '=', $user_id)->andWhere('delivered','=',true)->first();

            if (count(($delivery)>0) {
              
              return true;

            }
           
             return false;

        }



public static function checkshipmentissued($user_id=null) {

            $issue = \App\Shipment::where( 'user_id', '=', $user_id)->andWhere('issued','=',true)->first();

            if (count($issue)) > 0 {
              
              return true;

            }
           
            return false;

        }











}
