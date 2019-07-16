<?php

namespace Tests;

use Redis;
use Config;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Login Admin
     * 
     * @return void
     */
    public function loginAdmin()
    {
    	$user = factory(User::class)->create();

	    Config::push('sgcast.administrators', $user->email);

	    $this->actingAs($user);
    }

    public function flushRedis()
    {
        Redis::flushall();
    }
}
