<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Group_user extends Model
{
    protected $fillabe = ['user_id','group_id'];

    protected $guarded = [];

    protected $table ='Group_users';
    
}