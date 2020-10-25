<!--自分以外のユーザーのとこに表示-->
@if (Auth::id() != $user->id)
    <!--すでにフォローしてる場合はアンフォローボタン表示-->
    @if ( Auth::user()->is_following($user->id) )
        {!! Form::open([ 'route' => [ 'user.unfollow', $user->id ], 'method' => 'delete' ] ) !!}
            {!! Form::submit( 'Unfollow', [ 'class' => "btn btn-danger btn-block" ] ) !!}
        {!! Form::close() !!}
     <!--フォローしてない場合はフォローボタン表示-->   
    @else
        {!! Form::open( [ 'route' => [ 'user.follow', $user->id ] ] ) !!}
            {!! Form::submit( 'Follow', [ 'class' => "btn btn-primary btn-block" ] ) !!}
        {!! Form::close() !!}
    @endif
    
@endif