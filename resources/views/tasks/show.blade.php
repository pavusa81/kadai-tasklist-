@extends('layouts.app')

@section('content')
    @if (Auth::id() == $task->user_id)
    <h1>id = {{ $task->id }} のタスク詳細ページ</h1>
    
    <table class="table table table-bordered">
        <tr>
            <th class="table-dark">id</th>
            <td>{{ $task->id }}</td>
        </tr>
         <tr>
            <th class="table-dark">ユーザー名</th>
            <td>{{ \Auth::user()->name }}</td>
        </tr>
        <tr>
            <th class="table-dark">ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>
        <tr>
            <th class="table-dark">タスク</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
        {!! link_to_route('tasks.index', 'タスク一覧' , [],['class' => 'btn btn-outline-dark']) !!}
        {!! link_to_route('tasks.edit' , 'このタスクを編集' , ['task' => $task->id], ['class' => 'btn btn-outline-dark']) !!}
    
        {!! Form::model($task , ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
            {!! Form::submit('削除', ['class' => 'btn btn-outline-danger']) !!}
        {!! Form::close() !!}
    @else
        @include('welcome')
    @endif
@endsection