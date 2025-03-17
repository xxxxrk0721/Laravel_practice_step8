<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    // タスクの一覧・または検索結果を表示
    public function index(Request $request)
    {
        $query = DB::table('task_lists')->whereNull('deleted_at');
//            $tasks = DB::select('select * from task_lists');
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
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 検索キーワードが送信された場合（タスク名で検索）
        if ($request->filled('task_name')) {
            $query->where('task_name', 'like', '%' . $request->task_name . '%');
        }

        // 検索キーワードが送信された場合（日付で検索）
        if ($request->filled('ymd_to')) {
            $query->where('ymd_to',$request->ymd_to);
        }

        // 検索キーワードが送信された場合（日付で検索）
        if ($request->filled('ymd_from')) {
            $query->where('ymd_from', $request->ymd_from);
        }

        // ユーザーID
        if ($request->filled('user_id')) {
            $query->where('user_id', 'like', '%' . $request->user_id . '%');
        }
        $tasks = $query->paginate(10);
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
//        dd($request->method('POST'));
        if ($request->method() === 'POST') {
            // バリデーション
//            $validator = Validator::make($request->all(), [
            $validatedData = $request->validate([
                'task_name' => 'required|string|max:20',
                'ymd_to' => 'required',
                'ymd_from' => 'required',
                'task_content' => 'required|string|max:50',
                'user_id' => 'required',
                'status' => 'required',
//                'deleted_at' => 'required',
//            dd(123)
            ]);

//            if ($validatedData['deleted_at'] === '0') {
//                $validatedData['deleted_at'] = null;
//            }

            // バリデーションエラーを出力
//            if ($validator->fails()) {
//                dd($validator->errors()->all()); // エラー内容を表示
//            }

//            dd(123);
//            dd($validatedData);

            // 新しいタスクを作成して保存
            TaskList::create($validatedData);

            // 登録完了後、編集画面（`store` メソッド）に戻る
//            return redirect()->route('tasks.store')->with('success', 'タスクを登録しました。');
//            dd($request->method());
            return back()->with('success', 'タスクを登録しました。');

//            dd(123);
        }


//        if ($request->method() === 'GET') {
            return view('task.store');
//        }
//        return redirect()->route('tasks.store');

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
//        dd(123);
        return view('task.edit', compact('task'));  // 'task.edit' ビューを返す
    }

    // タスクを更新
    public function update(Request $request, $id)
    {

//        dd($request->all());
        // バリデーション
        $validatedData = $request->validate([
//        $validator = Validator::make($request->all(), [
//            dd(123),
            'task_name' => 'required',
            'ymd_to' => 'required',
            'ymd_from' => 'required',
            'task_content' => 'required',
            'user_id' => 'required',
            'status' => 'required',
//            'deleted_at' => 'required',
        ]);

//         バリデーションエラーを出力
//            if ($validator->fails()) {
//                dd($validator->errors()->all()); // エラー内容を表示
//            }


//        if ($validatedData['deleted_at'] === '0') {
//            $validatedData['deleted_at'] = null;
//        }

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->update($validatedData);  // タスクを更新
//        $task->update($validator);  // タスクを更新

        return back()->with('success', 'タスクを編集しました。');
//        return redirect()->route('tasks.index');  // タスク一覧にリダイレクト
    }

    // タスクを削除
    public function destroy($id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->delete();  // タスクを削除(ソフトデリート)

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました');  // タスク一覧にリダイレクト
    }
}
