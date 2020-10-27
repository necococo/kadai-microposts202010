<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    
    //follow unfollow関係
    //フォローしているユーザー一覧取得
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }


    //フォロワー一覧取得
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    
    //引数のユーザーをすでにフォローしているかどうか判定
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    
    public function feed_microposts() {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        // dd($follow_user_ids);
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    
    
    //post_favo table関係
    //public 宣言されたものはどこからでもアクセス可能。
    public function favorite_posts()
    {
        return $this->belongsToMany(Micropost::class, 'post_favo', 'user_id', 'post_id')->withTimestamps();
    }
    
    
    //すでにfavoしているかどうかの判定
    public function is_favoriting($postId) 
    {
        
        //public 宣言されたクラスのメンバーには、どこからでもアクセス可能です。
        return $this->favorite_posts()->where('post_id', $postId)->exists();
    }
    
    
    public function favorite($postId)
    {
        
        $exist = $this->is_favoriting($postId);
        // $its_mine = $this->microposts()->where('id', $postId)->exists();
       
        if($exist) {
            return false;
        }else {
            $this->favorite_posts()->attach($postId);
            return true;
        }
    }
    
    

    public function unfavorite($postId)
    {
        
        $exist = $this->is_favoriting($postId);
        // $its_mine = $this->microposts()->where('id', $postId)->exists();
       
        if($exist) {
            $this->favorite_posts()->detach($postId);
            return true;
            
        }else {
            return false;
        }
    }
}
