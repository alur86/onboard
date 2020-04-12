<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiUsersControllerTest extends TestCase
{
 

   public function testNewUserPayment(){
       
     $response = $this->post('Api:ApiUsersController:store', [
        'account_from' => '123',
        'account_to' => '321',
        'ammount' => '100',
    ]);

    $response->assertRedirect(route('home'));

    }




}
