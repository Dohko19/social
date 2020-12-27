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
                    ->waitForText('Cancelar solicitud')
                    ->assertSee('Cancelar solicitud')
                    ->visit(route('users.show', $recipient))
                    ->waitForText('Cancelar solicitud')
                    ->assertSee('Cancelar solicitud')
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
    public function guest_cannot_create_friendship_requests()
    {
        $recipient = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($recipient) {
            $browser->visit(route('users.show', $recipient))
                    ->press('@request-friendship')
                    ->assertPathIs('/login')
            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function a_user_cannot_send_friend_request_to_itself()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit(route('users.show', $user))
                    ->assertMissing('@request-friendship')
                    ->assertSee('Eres tu')
            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function senders_can_delete_accepted_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'recipient_id' => $recipient->id,
            'sender_id' => $sender->id,
            'status' => 'accepted'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->waitForText('Eliminar de mis amigos')
                ->assertSee('Eliminar de mis amigos')
                ->press('@request-friendship')
                ->waitForText('Solicitar amistad')
                ->assertSee('Solicitar amistad')
                ->visit(route('users.show', $recipient))
                ->waitForText('Solicitar amistad')
                ->assertSee('Solicitar amistad')

            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function senders_cannot_delete_denied_friendship_request()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'recipient_id' => $recipient->id,
            'sender_id' => $sender->id,
            'status' => 'denied'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->waitForText('Solicitud denegada')
                ->assertSee('Solicitud denegada')
                ->press('@request-friendship')
                ->waitForText('Solicitud denegada')
                ->assertSee('Solicitud denegada')
                ->visit(route('users.show', $recipient))
                ->waitForText('Solicitud denegada')
                ->assertSee('Solicitud denegada')

            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function recipients_can_accept_friendship_request()
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
                ->assertSee($sender->name)
                ->press('@accept-friendship')
                ->waitForText('son amigos')
                ->assertSee('son amigos')
                ->visit(route('accept-friendships.store'))
                ->waitForText('son amigos')
            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function recipients_can_deny_friendship_request()
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
                ->assertSee($sender->name)
                ->press('@deny-friendship')
                ->waitForText('Solicitud denegada')
                ->assertSee('Solicitud denegada')
                ->visit(route('accept-friendships.store'))
                ->waitForText('Solicitud denegada')
            ;
        });
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function recipients_can_delete_friendship_request()
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
                ->assertSee($sender->name)
                ->press('@delete-friendship')
                ->waitForText('Solicitud eliminada')
                ->assertSee('Solicitud eliminada')
                ->visit(route('accept-friendships.store'))
                ->assertDontSee('Solicitud eliminada')
                ->assertDontSee($sender->name)
            ;
        });
    }
}
