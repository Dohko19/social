<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;
use App\Models\Status;
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
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals($status->id, $statusResource['id']);
        $this->assertEquals($status->body, $statusResource['body']);
        $this->assertEquals($status->user->name, $statusResource['user_name']);
        $this->assertEquals('https://avatarfiles.alphacoders.com/141/141175.gif', $statusResource['user_avatar']);
        $this->assertEquals($status->created_at->diffForHumans(), $statusResource['ago']);
        $this->assertEquals(false, $statusResource['is_liked']);
        $this->assertEquals(0, $statusResource['likes_count']);
    }
}
