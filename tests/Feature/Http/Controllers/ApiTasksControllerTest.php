<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTasksControllerTest extends TestCase
{
  


public function testNewTask(){
       
     $response = $this->post('Api:ApiTasksController:store', [
        'location_id' => '1',
        'shipment_id' => '1',
        'task_name' => 'New Task',
        'ammount' => '100',
        'status' => 'false',
    ]);

    $response->assertRedirect(route('home'));

    }
}
