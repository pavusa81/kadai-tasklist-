@extends('layouts.app')

@section('content')
    @if (Auth::check())
        {!! link_to_route('tasks.index', 'タスク一覧' , [] , ['class' => 'btn btn-outline-dark']) !!}
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>TaskList</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', '新規登録ページへ', [], ['class' => 'btn btn-lg btn-outline-dark']) !!}
            </div>
        </div>
    @endif
@endsection