<?php

namespace App;
use App\Category;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'user_name', 'category_id','description','token'
    ];

    public function category () {
        return $this->belongsTo(Category::class);
    }
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
