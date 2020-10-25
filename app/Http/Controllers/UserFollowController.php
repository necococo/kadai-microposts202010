<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Micropost;

class UserFollowController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->follow($id);
        return redirect()->back();
    }
    
    //ルーティングの引数について　なぜRequset $requestがいらないか　https://readouble.com/laravel/5.5/ja/routing.html
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return redirect()->back();
    }
    
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);
        //usersでviewに渡すとこに注意
        $data = [
            'user'=>$user,
            'users'=>$followings
        ];
        $data += $this->conts($user);
        
        return View('users.followings', $data);
    }
    
    
    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);
        //usersでviewに渡すとこに注意
        $data = [
            'user'=>$user,
            'users'=>$followers
        ];
        $data += $this->conts($user);
        
        return View('users.followers', $data);
    }
}
