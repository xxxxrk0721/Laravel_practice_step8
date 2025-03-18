<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    // タスクの一覧・または検索結果を表示
    public function index(Request $request)
    {
        $query = DB::table('task_lists')->whereNull('deleted_at');

        // ユーザー一覧を取得（DBに登録されている users.id と users.name）
        $users = User::select('id', 'name')->get();

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
            $query->where('user_id', $request->user_id);
        }
        $tasks = $query->paginate(10);
        // 検索結果をビューに渡す
        return view('task.index', compact('tasks','users'));
    }

    public function userIndex(Request $request)
    {
        // 現在ログインしているユーザーの ID を取得
        $userId = Auth::guard('users')->id();

        // 条件を適用して task_lists テーブルのデータを取得
        $query = DB::table('task_lists')
            ->where('user_id', $userId)
            ->whereNull('deleted_at');

        // ユーザーテーブルから名前を取得
        $users = User::where('id',$userId)->select( 'name')->first();

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
        return view('admin.top', compact('tasks','users'));
    }

    // タスク作成フォームを表示
    public function create()
    {
        return view('task.create');  // タスク作成のビューを返す
    }

    // 新しいタスクを保存
    public function store(Request $request)
    {

        // ユーザー一覧を取得（DBに登録されている users.id と users.name）
        $users = User::select('id', 'name')->get();

        if ($request->method() === 'POST') {
            // バリデーション
            $validatedData = $request->validate([
                'task_name' => 'required|string|max:20',
                'ymd_to' => 'required',
                'ymd_from' => 'required',
                'task_content' => 'required|string|max:50',
                'user_id' => 'required',
                'status' => 'required',
            ]);

            // 新しいタスクを作成して保存
            TaskList::create($validatedData);

            // 登録完了後、編集画面（`store` メソッド）に戻る
            return back()->with('success', 'タスクを登録しました。');

        }
            return view('task.store',compact('users'));

    }

    public function userStore(Request $request)
    {
        if ($request->method() === 'POST') {
            // バリデーション
            $validatedData = $request->validate([
                'task_name' => 'required|string|max:20',
                'ymd_to' => 'required',
                'ymd_from' => 'required',
                'task_content' => 'required|string|max:50',
                'status' => 'required',
            ]);

            // ログインユーザーのIDを追加
            $validatedData['user_id'] = Auth::guard('users')->id(); // ← 自動でログインユーザーのIDをセット

            // 新しいタスクを作成して保存
            TaskList::create($validatedData);

            return back()->with('success', 'タスクを登録しました。');

        }
        return view('task.store_user');
    }

    // タスク編集フォームを表示
    public function edit($id)
    {

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        // ユーザー一覧を取得（DBに登録されている users.id と users.name）
        $users = User::select('id', 'name')->get();

        return view('task.edit', compact('task','users'));  // 'task.edit' ビューを返す
    }

    public function userEdit($id)
    {

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得

        return view('task.edit_user', compact('task'));  // 'task.edit' ビューを返す
    }

    // タスクを更新
    public function update(Request $request, $id)
    {
        // バリデーション
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:20',
            'ymd_to' => 'required',
            'ymd_from' => 'required',
            'task_content' => 'required|string|max:50',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->update($validatedData);  // タスクを更新

        return back()->with('success', 'タスクを編集しました。');
    }

    public function userUpdate(Request $request, $id)
    {

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:20',
            'ymd_to' => 'required',
            'ymd_from' => 'required',
            'task_content' => 'required|string|max:50',
            'status' => 'required',
        ]);

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->update($validatedData);  // タスクを更新

        return back()->with('success', 'タスクを編集しました。');
    }

    // タスクを削除
    public function destroy($id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->delete();  // タスクを削除(ソフトデリート)

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました');  // タスク一覧にリダイレクト
    }

    public function userDestroy($id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得
        $task->delete();  // タスクを削除(ソフトデリート)

        return redirect()->route('user.dashboard')->with('success', 'タスクを削除しました');  // タスク一覧にリダイレクト
    }
}
