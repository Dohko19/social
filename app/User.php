<?php

namespace App;

use App\Models\Friendship;
use App\Models\Status;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

//    protected $fillable = [
//        'name', 'email', 'password',
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatar'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function link()
    {
        return route('users.show', $this);
    }

    public function avatar()
    {
        return 'https://avatarfiles.alphacoders.com/141/141175.gif';
    }

    public function getAvatarAttribute()
    {
       return $this->avatar();
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function friendshipRequestReceived()
    {
        return $this->hasMany(Friendship::class, 'recipient_id');
    }

    public function friendshipRequestSent()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    public function sendFriendRequestTo($recipient)
    {
        return $this->friendshipRequestSent()->firstOrCreate([
            'recipient_id' => $recipient->id
        ]);
    }

    public function acceptFriendRequestFrom($sender)
    {
        $friendship = $this->friendshipRequestReceived()->where([
            'sender_id' => $sender->id,
        ])->first();

        $friendship->update(['status' => 'accepted']);

        return $friendship;
    }

    public function denyFriendRequestFrom($sender)
    {
        $friendship = $this->friendshipRequestReceived()->where([
            'sender_id' => $sender->id,
        ])->first();

        $friendship->update(['status' => 'denied']);

        return $friendship;
    }
}
