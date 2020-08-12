@extends('layouts.app')

@section('content')
    @if (Auth::check())
        @include('tasks.index')
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