<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_can_not_create_statuses()
    {
        $response = $this->postJson(route('statuses.store'), ['body' => 'mi primer estado']);

        $response->assertStatus(401);
    }


    /** @test */
    public function a_authenticate_user_can_create_statuses()
    {
       $this->withoutExceptionHandling();
       // given => teniendo un usuario autenticado
       $user = factory(User::class)->create();
       $this->actingAs($user);


       // when => cuando hace un post request a status
       $response = $this->postJson  (route('statuses.store'), ['body' => 'mi primer estado']);

       $response->assertJson([
           'data' => ['body' => 'mi primer estado']
       ]);
       // then => entonces veo un nuevo estado en la base de datos
       $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'mi primer estado'
       ]);


    }

    /** @test */
    public function a_status_requires_a_body()
    {

       // given => teniendo un usuario autenticado
       $user = factory(User::class)->create();
       $this->actingAs($user);


       // when => cuando hace un post request a status
       $response = $this->postJson(route('statuses.store'), ['body' => '']);

       $response->assertStatus(422);

      $response->assertJsonStructure([
          'message', 'errors' => ['body']
      ]);

    }

        /** @test */
        public function a_status_body_requires_a_minium_length()
        {

           // given => teniendo un usuario autenticado
           $user = factory(User::class)->create();
           $this->actingAs($user);


           // when => cuando hace un post request a status
           $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

           $response->assertStatus(422);

          $response->assertJsonStructure([
              'message', 'errors' => ['body']
          ]);

        }
}
