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
}
