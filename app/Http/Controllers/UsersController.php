<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', ['users'=> $users,]);
    }
    
    public function show($id)
    {
        $data=[];
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        $data=['user'=> $user,'microposts'=>$microposts,];
        $data += $this->counts($user);
        return view('users.show', $data);
    }
    
    
    public function followings($id)
    {
        $data=[];
        $user = User::find($id);
        //ここで中間テーブルにアクセス
        $followings = $user->followings()->paginate(10);
        //usersでviewに渡すとこに注意
        $data = [
            'user'=>$user,
            'users'=>$followings
        ];
        $data += $this->counts($user);
        
        return View('users.followings', $data);
    }
    
    
    public function followers($id)
    {
        $data=[];
        $user = User::find($id);
        //ここで中間テーブルにアクセス
        $followers = $user->followers()->paginate(10);
        //usersでviewに渡すとこに注意 users.blade.phpを使いまわしたいので
        $data = [
            'user'=>$user,
            'users'=>$followers
            ];
        $data += $this->counts($user);
        
        return View('users.followers', $data);
    }
    
    
    public function favorite_posts($id) {
        $data=[];
        $user = User::find($id);
        //ここで中間テーブルにアクセス
        $favorite_posts = $user->favorite_posts()->paginate(10);
        //micropostsでviewに渡すとこに注意 microposts.blade.phpを使いまわしたいので
        $data = [
            'user'=>$user,
            'microposts'=>$favorite_posts
            ];
        $data += $this->counts($user);
        
        return View('users.favorite_posts', $data);
    }
    
    
    
}
