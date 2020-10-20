<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanSeeProfileTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @test void
     * @throws \Throwable
     */
    public function user_can_see_profiles()
    {
        $user = factory(User::class)->create();
        $statuses = factory(Status::class, 2)->create(['user_id' => $user->id]);
        $otherStatus = factory(Status::class)->create();
        $this->browse(function (Browser $browser) use ($user, $statuses, $otherStatus) {
            $browser->visit("/@{$user->name}")
                ->assertSee($user->name) 
                ->waitForText($statuses->first()->body)
                ->assertSee($statuses->first()->body)
                ->assertSee($statuses->last()->body)
                ->assertDontSee($otherStatus->body)
            ;
        });
    }

    /**
    * @test void
    * @throws \Throwable
    */
    public function user_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name','')
                ->press('@register-btn')
                ->assertPathIs('/register')
                ->assertPresent('@validation-errors')
            ;
        });
    }
}
