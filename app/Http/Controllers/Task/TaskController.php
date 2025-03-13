<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TaskController extends Controller
{
    // タスクの一覧・または検索結果を表示
    public function index(Request $request)
    {
            $tasks = DB::select('select * from task_lists');
//        $tasks = TaskList::all();
//        $query = TaskList::query();  // TaskList モデルのクエリビルダーを初期化
//
//        // 名前で検索
//        if ($request->has('name') && $request->name) {
//            $query->where('name', 'like', '%' . $request->name . '%');
//        }
//        TaskList::all();
//        // ymd from-toで検索
//        // リクエストパラメータから日付を取得
//        $ymd_to = $request->input('ymd_to');
//        $ymd_from = $request->input('ymd_from');
//
//        // ymd_to と ymd_from が両方とも提供されている場合
//        if ($ymd_to && $ymd_from) {
//            // ymd_to が ymd_to 以上、かつ ymd_from が ymd_from 以下
//            $query->where('ymd_to', '>=', $ymd_to)
//                ->where('ymd_from', '<=', $ymd_from);
//        }
//
//        // ステータスで検索
//        if ($request->has('status') && $request->status) {
//            $query->where('status', $request->status);
//        }
//
//        // 検索結果を取得
//        $tasks = $query->get();

//        dd($tasks);

        // 検索結果をビューに渡す
        return view('task.index', compact('tasks'));
//        $tasks = TaskList::all();  // TaskList モデルからすべてのタスクを取得
//        return view('task.index', compact('tasks'));  // 'task.index' ビューを返す
    }

    // タスク作成フォームを表示
    public function create()
    {
        return view('task.create');  // タスク作成のビューを返す
    }

    // 新しいタスクを保存
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:20',
            'ymd_to' => 'required|regex:/^\d{8}$/',
            'ymd_from' => 'required|regex:/^\d{8}$/',
            'task_content' => 'required|string|max:50',
            'user_id' => 'required|regex:/^\d{6}$/',
            'status' => 'required|regex:/^(01|02|03)$/',
            'del_flg' => 'required|regex:/^(1|0)$/',
        ]);

        // 新しいタスクを作成して保存
        TaskList::create($validatedData);

        return redirect()->route('tasks.index');  // タスク一覧にリダイレクト
    }

    // タスク詳細を表示
//    public function show($id)
//    {
//        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
//        return view('task.show', compact('task'));  // 'task.show' ビューを返す
//    }

    // タスク編集フォームを表示
    public function edit($id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        return view('task.edit', compact('task'));  // 'task.edit' ビューを返す
    }

    // タスクを更新
    public function update(Request $request, $id)
    {
        // バリデーション
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:20',
            'ymd_to' => 'required|regex:/^\d{8}$/',
            'ymd_from' => 'required|regex:/^\d{8}$/',
            'task_content' => 'required|string|max:50',
            'user_id' => 'required|regex:/^\d{6}$/',
            'status' => 'required|regex:/^(01|02|03)$/',
            'del_flg' => 'required|regex:/^(1|0)$/',
        ]);

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->update($validatedData);  // タスクを更新

        return redirect()->route('tasks.index');  // タスク一覧にリダイレクト
    }

    // タスクを削除
    public function destroy($id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->delete();  // タスクを削除

        return redirect()->route('tasks.index');  // タスク一覧にリダイレクト
    }
}
