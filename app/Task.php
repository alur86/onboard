<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
protected $fillable = [

      'location_id', 'shipment_id', 'user_id', 'task_name', 'status',
  ];


protected $hidden = ['created_at', 'updated_at'];





 public $timestamps = true;	
    
 protected $table = 'shipments';




 public function user()
    {
        return $this->belongsTo('App\User');
    }



public function locations(){

        return $this->hasMany('App\Location');
    }


public function shipments(){
	
        return $this->hasMany('App\Shipment');
    }







 public static function checktask($user_id=null) {

            $task = \App\Task::where( 'user_id', '=', $user_id)->andWhere('status','=',true)->first();

            if (count($task)>0) {
              
              return true;

            }
           
            return false;

        }



 public static function maketask($location_id=null, $user_id=null,$shipment_id=null,  $task_name,$status) {

                $task = new \App\Task();
                $task->shipment_id = $shipment_id;
                $task->user_id = $user_id;
                $task->task_name =$task_name;
                $task->status= $status;
                $task->created_at = date("Y-m-d H:i:s");
                $task->save();

 }







}
