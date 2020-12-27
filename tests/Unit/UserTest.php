<?php

namespace Tests\Unit;

use App\Models\Friendship;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function route_key_is_set_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name', $user->getRouteKeyName(), 'The route key must be name');
    }

    /** @test */
    public function user_has_a_link_to_their_profile()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(route('users.show', $user), $user->link());
    }

    /** @test */
    public function user_has_a_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('https://avatarfiles.alphacoders.com/141/141175.gif', $user->avatar());
        $this->assertEquals('https://avatarfiles.alphacoders.com/141/141175.gif', $user->avatar);
    }

    /** @test */
    public function a_users_has_many_statuses()
    {
        $user = factory(User::class)->create();

        factory(Status::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Status::class, $user->statuses->first());
    }

    /** @test */
    public function a_user_can_send_friend_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $friendship =  $sender->sendFriendRequestTo($recipient);

        $this->assertTrue($friendship->sender->is($sender));
        $this->assertTrue($friendship->recipient->is($recipient));
    }

    /** @test */
    public function a_user_can_accept_friend_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $friendship = $recipient->acceptFriendRequestFrom($sender);

        $this->assertEquals('accepted', $friendship->status);
    }

    /** @test */
    public function a_user_can_deny_friend_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $friendship = $recipient->denyFriendRequestFrom($sender);

        $this->assertEquals('denied', $friendship->status);
    }

    /** @test */
    public function a_user_can_get_all_their_friend_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $this->assertCount(1, $recipient->friendshipRequestReceived);
        $this->assertInstanceOf(Friendship::class, $recipient->friendshipRequestReceived->first());

        $this->assertCount(1, $sender->friendshipRequestSent);
        $this->assertInstanceOf(Friendship::class, $sender->friendshipRequestSent->first());
    }

    /** @test */
    public function a_user_can_get_their_frinds()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->sendFriendRequestTo($recipient);

        $this->assertCount(0, $recipient->friends());
        $this->assertCount(0, $sender->friends());

        $recipient->acceptFriendRequestFrom($sender);


        $this->assertCount(1, $recipient->friends());
        $this->assertCount(1, $sender->friends());

        $this->assertEquals($recipient->name, $sender->friends()->first()->name);
        $this->assertEquals($sender->name, $recipient->friends()->first()->name);
    }
}
