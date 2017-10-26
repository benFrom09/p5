<?php
namespace Tests\Feature;

use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGroup extends TestCase
{
    /*
    public function setUp() {
        parent::setUp();
        Artisan::call('migrate');
    }
    */
    /**
     * A basic test example.
     *
     * @return void
     * 
     */
    public function testExample()
    {
        $user = User::first();
        Group::create(["name" =>"deuxieme groupe", "user_email" =>$user->email]);

        $this->assertEquals(1,Group::count());
    }
}
