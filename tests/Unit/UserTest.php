<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form(){
           $response = $this->get('/login');
           $response->assertStatus(200);
    }

    public function test_user_duplication(){
        $user1 = User::make([
            'name' => 'john doe',
            'email' => 'johndoe@gmail.com',            
        ]);
        $user2 = User::make([
            'name' => 'mary',
            'email' => 'mary@gmail.com',            
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user(){
        $user = User::factory()->count(1)->make();
        $user = User::first();
        if($user){
            $user->delete();
        }
        $this->assertTrue(true);
    }

    public function test_it_stores_new_users(){
        $response = $this->post('/register',[
            'name' => 'kamal',
            'email' => 'kamal@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertRedirect('/home');
    }

    public function test_database(){
        $this->assertDatabaseMissing('users',[
            'name' => 'mary',
        ]);
    }

    public function test_if_seeder_works(){
        $this->seed(); //seed all seeders in the seeders folder
        //php artisan db:seed
    }

}
