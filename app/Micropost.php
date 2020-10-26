<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    
    //favo unfavo関係  いらないかも
    public function favoriting_users()
    {
        return $this->belongsToMany(User::class, 'post_favo', 'post_id', 'user_id')->withTimestamps();
    }
}
