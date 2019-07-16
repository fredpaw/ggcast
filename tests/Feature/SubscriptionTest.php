<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Lesson;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
  use RefreshDatabase;

  public function test_a_user_without_a_plan_cannot_watch_premium_lessons()
  {
  	// $this->withoutExceptionHandling();

  	$user = factory(User::class)->create();
  	$this->actingAs($user);

  	$lesson1 = factory(Lesson::class)->create(['premium' => 1]);
  	$lesson2 = factory(Lesson::class)->create(['premium' => 0]);

  	$this->get("/series/{$lesson1->series->slug}/lesson/{$lesson1->id}")
  			 ->assertRedirect('/subscribe');

  	$this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
  			 ->assertViewIs('watch');
  }

  public function test_a_user_on_any_plan_can_watch_all_lessons()
  {
  	$user = factory(User::class)->create();
  	$this->actingAs($user);

  	$lesson1 = factory(Lesson::class)->create(['premium' => 1]);
  	$lesson2 = factory(Lesson::class)->create(['premium' => 0]);

  	$this->fakeSubscribe($user);

  	$this->get("/series/{$lesson1->series->slug}/lesson/{$lesson1->id}")
  			 ->assertViewIs('watch');

  	$this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
  			 ->assertViewIs('watch');
  }

  public function fakeSubscribe($user)
  {
  	$user->subscriptions()->create([
  		'name' => 'yearly',
  		'stripe_id' => 'Fake_stripe_id',
  		'stripe_plan' => 'yearly',
  		'quantity' => 1
  	]);
  }
}
