<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Events\StatusCreated;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\StatusResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    public function an_authenticate_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);

       // given => teniendo un usuario autenticado
       $user = factory(User::class)->create();
       $this->actingAs($user);


       // when => cuando hace un post request a status
       $response = $this->postJson(route('statuses.store'), ['body' => 'mi primer estado']);

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
    public function an_event_is_fired_when_a_status_is_created()
    {
        Event::fake([StatusCreated::class]);
       \Broadcast::shouldReceive('socket')->andReturn('socket-id');
        $this->withoutExceptionHandling();
        // given => teniendo un usuario autenticado
        $user = factory(User::class)->create();

        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'mi primer estado']);

        Event::assertDispatched(StatusCreated::class, function ($statusCreatedEvent) {
            $this->assertInstanceOf(StatusResource::class, $statusCreatedEvent->status);
            $this->assertTrue(Status::first()->is($statusCreatedEvent->status->resource) );
            $this->assertEventChannelType('public', $statusCreatedEvent);
            $this->assertEventChannelName('statuses', $statusCreatedEvent);
            $this->assertDontBoradcastToCurrentUser($statusCreatedEvent);


            return true;
        });
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
