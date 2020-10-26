<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data=[];
        if ( \Auth::check() ) {
            $user = \Auth::user();
            $microposts =$user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = ['user' => $user, 'microposts' => $microposts,];
            // $data += $this->counts($user);
            
            return view('welcome', $data);
        }else{
            return view('welcome');
        }
    }
    
    
    
    
    //このときはまだmicropostのidはない
    public function store(Request $request)
    {
        $this->validate($request, ['content'=>'required|max:191',]);
        //このcreateメソッドはlaravelが提供するEloquentが持っているメソッドで配列を受け付けてくれるので一気にデータを作れる
        //storeにはauthはいらない
        $request->user()->microposts()->create(['content'=>$request->content]);
        
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);
        //ログインして操作しているユーザーと削除対象の投稿の持ち主が一致していればというif文
        if(\Auth::id() == $micropost->user_id){
            $micropost->delete();
        }
        
        return redirect()->back();
    }
}
