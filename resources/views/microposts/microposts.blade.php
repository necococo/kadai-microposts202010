<ul class="media-list">
    @foreach($microposts as $micropost)
        <?php $user = $micropost->user; ?>
        <li class="media">
            <div class="media-left">
                <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
            </div>
            <div class="media-body">
                <div>
                    {!! link_to_route('users.show', $user->name, ['id'=>$user->id]) !!}
                </div>
                <div>
                    <p>{!! nl2br(e($micropost->content)) !!}</p>
                </div>
                <div>
                    @if (Auth::id() == $micropost->user_id)
                        {!! Form::open(['route'=>['microposts.destroy', $micropost->id], 'method'=>'delete']) !!}
                            {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{!! $microposts->render() !!}

<!-- nl2brは改行に対応  e関数は、PHPのhtmlspecialchars関数をdouble_encodeオプションにfalseを指定し、実行します。要は特殊文字をエスケープしそのまま出力します-->
