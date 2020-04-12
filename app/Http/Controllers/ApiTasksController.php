<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Order;
use App\Shipment;
use Illuminate\Support\Facades\Auth;

class ApiTasksController extends Controller
{
  

  public function __construct()
    {
        $this->middleware('auth');
    }


   


public function store (Request $request) {

$user = Auth::user();  
$user_id = $user->id;


   $tasks = Validator::make($req->all(), [

            'location_id' => 'required|numeric|min:2|max:10',
            'shipment_id' => 'required|numeric|min:5|max:60',
            'task_name' => 'required|min:10|max:100',
            'ammount' => 'required|numeric|min:2|max:10',
            'status' => 'required|min:5|max:7',
        ]);



    if ($tasks->passes()) {

        	$location_id=intval($req->post('location_id'));
        	$shipment_id=intval($req->post('shipment_id'));
        	$task_name=$req->post('task_name');
            $amount=floatval($req->post('amount'));
        	$status=$req->post('status');



$check_task=\App\Task::checktask($user_id);

$check_delivery=App\Shipment::checkshipmentdelivery($user_id);

$check_issued=App\Shipment::checkshipmentissued($user_id);

if ($check_task==false && $check_delivery==false && $check_issued == false) {

$task =\App\Task::maketask($location_id, $user_id,$shipment_id, $task_name,$status);

$order = \App\Order:: makeorder($amount,$location_id);

return response()->json($task,$order, 200);

}



else {

return redirect()->back();


}



}




}
