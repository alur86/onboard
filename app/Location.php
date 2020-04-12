<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    
  
protected $fillable = [

      'shipment_id', 'order_id', 'address', 
  ];



protected $hidden = ['created_at', 'updated_at'];


 public $timestamps = true;	
    
 protected $table = 'locations';


 public function shipment()
    {
        return $this->belongsTo('App\Shipment');
    }



 public function order()
    {
        return $this->belongsTo('App\Order');
    }







}
