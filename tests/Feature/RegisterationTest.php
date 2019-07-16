<?php

namespace Tests\Feature;

use Mail;
use App\User;
use App\Mail\ConfirmYourEmail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterationTest extends TestCase
{

		use RefreshDatabase;

    /**
     * Test user will automatical get username after register.
     *
     * @return void
     */
    public function test_a_user_has_a_default_username_after_registeration()
    {
    	$this->withoutExceptionHandling();

      $this->post('/register', [
      	'name' => 'fred paw',
      	'email' => 'fred@paw.com',
      	'password' => 'secret'
      ])->assertRedirect();

      $this->assertDatabaseHas('users', [
      	'username' => str_slug('fred paw')
      ]);
    }

    /**
     * Test an email will sent to user after registeration
     *
     * @return  void
     */
    public function test_an_email_is_sent_to_newly_registered_user()
    {
    	$this->withoutExceptionHandling();

    	Mail::fake();

    	//register new user
    	$this->post('/register', [
      	'name' => 'fred paw',
      	'email' => 'fred@paw.com',
      	'password' => 'secret'
      ])->assertRedirect();

    	//assert that a particular email was sent
    	Mail::assertSent(ConfirmYourEmail::class);
    }

    /**
     * Test a user has a confirm token after registeration
     *
     * @return  void
     */
    public function test_a_user_has_a_token_after_registeration()
    {
    	Mail::fake();

    	//register new user
    	$this->post('/register', [
      	'name' => 'fred paw',
      	'email' => 'fred@paw.com',
      	'password' => 'secret'
      ])->assertRedirect();

      $user = User::find(1);

      $this->assertNotNull($user->confirm_token);
      $this->assertFalse($user->isConfirmed());
    }
}
