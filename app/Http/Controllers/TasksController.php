<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if(\Auth::check()) {
            $user = \Auth::user();
            
            $tasks = $user->tasks()->orderBy('id' , 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create' , [
            'task' => $task
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        $user = $task->user();
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show' ,[
                'task' => $task,
                'user' => $user,
            ]);
        }
             return redirect('/');
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit' ,[
                'task' => $task,
            ]);
        }
             return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id)  {
            $request->user()->tasks()->create([
                'status' => $request->status,
                'content' => $request->content,
            ]);
        }
        return redirect('/');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
        return redirect('/');
    }
}
