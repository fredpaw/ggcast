<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSeriesTest extends TestCase
{
	use RefreshDatabase;

  /**
   * A User can create a series.
   *
   * @return void
   */
  public function test_a_user_can_create_a_series()
  {
    $this->withoutExceptionHandling();
    
    $this->loginAdmin();

  	Storage::fake();

    $this->post('/admin/series', [
    	'title' => 'vuejs for the best',
    	'description' => 'the best vuejs casts ever',
    	'image' => UploadedFile::fake()->image('image-series.png')
    ])->assertRedirect()
    ->assertSessionHas('success', 'Series created successfully.');

    Storage::disk()->assertExists(
    	'public/series/' . str_slug('vuejs for the best') . '.png'
    );

    $this->assertDatabaseHas('series', [
    	'slug' => str_slug('vuejs for the best')
    ]);
  }

  /**
   * A series must has a title
   *
   * @return void
   */
  public function test_a_series_must_be_created_with_a_title()
  {
    $this->loginAdmin();

    $this->post('/admin/series', [
      'description' => 'the best vuejs casts ever',
      'image' => UploadedFile::fake()->image('image-series.png')
    ])
    ->assertSessionHasErrors('title');
  }

  /**
   * A series must has a description
   *
   * @return void
   */
  public function test_a_series_must_be_created_with_a_description()
  {
    $this->loginAdmin();

    $this->post('/admin/series', [
      'title' => 'vuejs for the best',
      'image' => UploadedFile::fake()->image('image-series.png')
    ])
    ->assertSessionHasErrors('description');
  }

  /**
   * A series must has a image
   *
   * @return void
   */
  public function test_a_series_must_be_created_with_an_actual_image()
  {
    $this->loginAdmin();
    
    $this->post('/admin/series', [
      'title' => 'vuejs for the best',
      'description' => 'the best vuejs casts ever',
      'image' => 'STRING_INVALID_IMAGE'
    ])
    ->assertSessionHasErrors('image');
  }

  /**
   * Test only admin can create series
   *
   * @return void
   */
  public function test_only_admin_can_create_series()
  {
    //user
    $this->actingAs(
      factory(User::class)->create()
    );
    //visit endpoint
    $this->post('/admin/series')->assertSessionHas('error', 'You are not authorized to perform this action');
    //assert we r redirected
  }
}
