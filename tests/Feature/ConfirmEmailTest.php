<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmEmailTest extends TestCase
{
	use RefreshDatabase;

  /**
   * A user can confirm email.
   *
   * @return void
   */
  public function test_a_user_can_confirm_email()
  {
  	$this->withoutExceptionHandling();

    // create user
    $user = factory(User::class)->create();

    // make a get request to the confirm endpoint
    $this->get("/register/confirm/?token={$user->confirm_token}")
    		 ->assertRedirect('/')
    		 ->assertSessionHas('success', 'Your email has been confirmed.');

    // assert that the user is confirmed
    $this->assertTrue($user->refresh()->isConfirmed());
  }

  /**
	 * Redirect user if the token is wrong
	 *
	 * @return  Redirect
	 */
	public function test_a_user_is_redirected_if_token_is_wrong()
	{
		$this->withoutExceptionHandling();

    // create user
    $user = factory(User::class)->create();

    // make a get request to the confirm endpoint
    $this->get("/register/confirm/?token=WRONG_TOKEN")
    		 ->assertRedirect('/')
    		 ->assertSessionHas('error', 'Confirmation token is not recognised.');
	}
}
