<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table ='users';

    public function groups() {
        
        return $this->belongsToMany(Group::class);
       
    }

    public function hasGroup() {

        if($this->groups()) {
            //dd(Group::get()[0]->name);
            return true;
        }
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function profile() {
        return $this->hasOne('App\Profile');
    }
}
