<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;


    /** @test */
    public function users_can_see_all_comments()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class, 2)->create(['status_id' => $status->id]);
            $this->browse(function (Browser $browser) use ($status, $comments) {
                $browser->visit('/')
                    ->waitForText($status->body);
                foreach ($comments as $comment){
                    $browser->assertSee($comments->body)
                        ->assertSee($comment->user->name)
                    ;
                }
            });

    }

    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($status, $user) {
            $comment = 'Mi primer comentario';
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->type('comment', $comment)
                    ->press('@comment-btn')
                    ->waitForText($comment)
                    ->assertSee($comment)
            ;
        });
    }

    /**
     *@test
     */
    public function users_can_see_comments_in_real_time()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($status, $user) {
            $comment = 'Mi primer comentario';

            $browser2->visit('/');

            $browser1->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn')
            ;

            $browser2->waitForText($comment)
                ->assertSee($comment);
        });
    }
}
