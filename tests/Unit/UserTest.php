<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
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
    }
}
