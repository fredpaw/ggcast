<?php

namespace Tests\Feature;

use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLessonTest extends TestCase
{
	use RefreshDatabase;
  /**
   * User can create a lesson
   *
   * @return void
   */
  public function test_a_user_can_create_lessons()
  {
  	$this->loginAdmin();
  	$this->withoutExceptionHandling();

  	$series = factory(Series::class)->create();
  	$lesson = [
  		'title' => 'new lesson',
  		'description' => 'new lessons description',
  		'episode_number' => 23,
  		'video_id' => 2222
  	];

  	$this->postJson("/admin/{$series->id}/lessons", $lesson)
  			 ->assertStatus(201)
  			 ->assertJson($lesson);

  	$this->assertDatabaseHas('lessons', [
  		'title' => $lesson['title']
  	]);
  }

  public function test_a_title_is_required_to_create_a_lesson()
  {
  	$this->loginAdmin();

  	$series = factory(Series::class)->create();
  	$lesson = [
  		'description' => 'new lessons description',
  		'episode_number' => 23,
  		'video_id' => 2222
  	];

  	$this->post("/admin/{$series->id}/lessons", $lesson)
  			 ->assertSessionHasErrors('title');
  }

  public function test_a_description_is_required_to_create_a_lesson()
  {
  	$this->loginAdmin();

  	$series = factory(Series::class)->create();
  	$lesson = [
  		'title' => 'new lesson',
  		'episode_number' => 23,
  		'video_id' => 2222
  	];

  	$this->post("/admin/{$series->id}/lessons", $lesson)
  			 ->assertSessionHasErrors('description');
  }

  public function test_a_episode_number_is_required_to_create_a_lesson()
  {
  	$this->loginAdmin();

  	$series = factory(Series::class)->create();
  	$lesson = [
  		'title' => 'new lesson',
  		'description' => 'new lessons description',
  		'video_id' => 2222
  	];

  	$this->post("/admin/{$series->id}/lessons", $lesson)
  			 ->assertSessionHasErrors('episode_number');
  }

  public function test_a_video_id_is_required_to_create_a_lesson()
  {
  	$this->loginAdmin();

  	$series = factory(Series::class)->create();
  	$lesson = [
  		'title' => 'new lesson',
  		'description' => 'new lessons description',
  		'episode_number' => 23,
  	];

  	$this->post("/admin/{$series->id}/lessons", $lesson)
  			 ->assertSessionHasErrors('video_id');
  }
}
