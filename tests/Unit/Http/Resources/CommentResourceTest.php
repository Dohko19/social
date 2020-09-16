<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */

    public function a_comment_resources_must_have_the_necesary_fields()
    {
        $comment = factory(Status::class)->create();

        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals(
            $comment->id,
            $commentResource['id']
        );

        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );


        $this->assertEquals(
            0,
            $commentResource['likes_count']
        );

        $this->assertEquals(
            false,
            $commentResource['is_liked']
        );

        $this->assertInstanceOf(
            UserResource::class,
            $commentResource['user']
        );

        $this->assertInstanceOf(
            User::class,
            $commentResource['user']->resource
        );
    }
}
