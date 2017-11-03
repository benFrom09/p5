<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $fillabe = [
        'content','user_id','group_id','post_images'

    ];

    public function users() {
        return $this->belongsTo(User::class);
    }
    
}
