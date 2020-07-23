<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class StatusTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */

    public function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user);
    }

    /**
     * @test
    */
    public function a_status_has_many_likes()
    {
        $status = factory(Status::class)->create();

        factory(Like::class)->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Like::class, $status->likes->first() );
    }

    /** @test */
    public function a_status_can_be_like()
    {
        $status = factory(Status::class)->create();

        $this->actingAs( factory(User::class)->create());

        $status->like();

        $this->assertEquals(1, $status->likes->count() );
    }

    /** @test */
    public function a_status_can_be_liked_once()
    {
        $status = factory(Status::class)->create();

        $this->actingAs( factory(User::class)->create());

        $status->like();

        $this->assertEquals(1, $status->likes->count() );

        $status->like();

        $this->assertEquals(1, $status->fresh()->likes->count() );
    }
}
