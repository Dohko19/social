<?php

namespace Tests\Browser;

use App\Models\Friendship;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanRequestFriendshipTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @return void
     * @throws \Throwable
     */
    public function senders_can_create_and_delete_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                    ->visit(route('users.show', $recipient))
                    ->press('@request-friendship')
                    ->waitForText('Cancelar Solicitud')
                    ->assertSee('Cancelar Solicitud')
                    ->visit(route('users.show', $recipient))
                    ->waitForText('Cancelar Solicitud')
                    ->press('@request-friendship')
                    ->waitForText('Solicitar amistad')
                    ->assertSee('Solicitar amistad')

            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function senders_can_accept_and_deny_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
           'recipient_id' => $recipient->id,
           'sender_id' => $sender->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->press('@accept-friendship')
                ->waitForText('son amigos')
                ->assertSee('son amigos')
                ->visit(route('accept-friendships.store'))
                ->waitForText('son amigos')
            ;
        });
    }
}
