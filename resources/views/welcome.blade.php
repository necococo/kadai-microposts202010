@extends('layouts.app')

@section('content')
    <!--もしログインしてたらそのインスタンスを獲得して名前表示-->
    @if (Auth::check())
        <?php $user = Auth::user(); ?>
        {{ $user->name }}
        
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microposts2nd</h1>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection