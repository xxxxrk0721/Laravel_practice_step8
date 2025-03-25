<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class TaskController extends Controller
{
    // タスクの一覧・または検索結果を表示
    public function index(Request $request)
    {
        // 現在ログインしている管理者の ID を取得
        $adminId = Auth::guard('admin')->id();

        $query = DB::table('task_lists')->whereNull('deleted_at');

//        // ユーザー一覧を取得（DBに登録されている users.id と users.name）
////        $users = User::select('id', 'name')->get();
//        // タスクが1つ以上あるユーザーのみ取得
//        $users = User::whereHas('TaskList')
//            ->select('id', 'name')
//            ->get();
        // ステータスの取得
        $status = $request->input('status');

        // ユーザーを取得
        $usersQuery = User::query();

        if ($status == "1") {
            // ステータスが「未着手」の場合、未着手のタスクがあるユーザーのみ取得
            $usersQuery->whereHas('TaskList', function ($query) {
                $query->where('status', 1);
            });
        } elseif ($status == "2") {
            // ステータスが「対応中」の場合、対応中のタスクがあるユーザーのみ取得
            $usersQuery->whereHas('TaskList', function ($query) {
                $query->where('status', 2);
            });
        } elseif ($status == "3") {
            // ステータスが「完了」の場合、完了のタスクがあるユーザーのみ取得
            $usersQuery->whereHas('TaskList', function ($query) {
                $query->where('status', 3);
            });
        } else {
            // タスクを持つすべてのユーザーを取得
            $usersQuery->whereHas('TaskList');
        }

        $users = $usersQuery->select('id', 'name')->get();

        // 管理者一覧を取得（DBに登録されている admins.name）
        $admins = Admin::where('id',$adminId)->select('name')->first();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 検索キーワードが送信された場合（タスク名で検索）
        if ($request->filled('task_name')) {
            $query->where('task_name', 'like', '%' . $request->task_name . '%');
        }

        // 検索キーワードのバリデーション
        $request->validate([
            'ymd_from' => 'nullable|date',
            'ymd_to' => 'nullable|date',
        ], [
            'ymd_from.date' => '終了日は正しい日付を入力してください。',
            'ymd_to.date' => '開始日は正しい日付を入力してください。',
        ]);

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

        foreach ($tasks as $task) {
            $dueDate = Carbon::parse($task->ymd_from); // 終了日（例）
            $now = Carbon::now();

            if ($dueDate->isPast()) {
                $task->due_status = 'overdue'; // 期限切れ
            } elseif ($dueDate->diffInDays($now) <= 3) {
                $task->due_status = 'near'; // 締切間近（3日以内）
            } else {
                $task->due_status = 'normal'; // 通常
            }
        }
        // 検索結果をビューに渡す
        return view('task.index', compact('tasks','users','admins'));
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

        // 検索キーワードのバリデーション
        $request->validate([
            'ymd_from' => 'nullable|date',
            'ymd_to' => 'nullable|date',
        ], [
            'ymd_from.date' => '終了日は正しい日付を入力してください。',
            'ymd_to.date' => '開始日は正しい日付を入力してください。',
        ]);

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

        // 今日の日付を取得
        $today = Carbon::today()->format('Y-m-d');

        // 並び替えを追加（期限切れを上に、次に締切が近い順）
        $query->orderByRaw("CASE WHEN ymd_from < ? AND status <> 3 THEN 0
                                 ELSE 1 END", [$today])
            ->orderBy('ymd_from', 'asc');

        $tasks = $query->paginate(10);

        foreach ($tasks as $task) {
            $dueDate = Carbon::parse($task->ymd_from); // 終了日（例）
            $now = Carbon::now();

            if ($dueDate->isPast()) {
                $task->due_status = 'overdue'; // 期限切れ
            } elseif ($dueDate->diffInDays($now) <= 3) {
                $task->due_status = 'near'; // 締切間近（3日以内）
            } else {
                $task->due_status = 'normal'; // 通常
            }
        }
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
                'ymd_to' => 'required|date',
                'ymd_from' => 'required|date',
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
                'ymd_to' => 'required|date',
                'ymd_from' => 'required|date',
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
            'ymd_to' => 'required|date',
            'ymd_from' => 'required|date',
            'task_content' => 'required|string|max:50',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得

        // データをセット（変更があるか判定するため）
        $task->fill($validatedData);

        // 変更があるかチェック
        if ($task->isDirty()) {
            // 変更がある場合は更新
            $task->update($validatedData);
            return back()->with('success', 'タスクを更新しました。');
        } else {
            // 変更がない場合はメッセージを表示
            return back()->with('info', '修正なし。変更がありませんでした。');
        }
    }

    public function userUpdate(Request $request, $id)
    {
        $task = TaskList::findOrFail($id);  // 指定されたIDのタスクを取得

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:20',
            'ymd_to' => 'required|date',
            'ymd_from' => 'required|date',
            'task_content' => 'required|string|max:50',
            'status' => 'required',
        ]);

        // データをセット（変更があるか判定するため）
        $task->fill($validatedData);

        // 変更があるかチェック
        if ($task->isDirty()) {
            // 変更がある場合は更新
            $task->update($validatedData);
            return back()->with('success', 'タスクを更新しました。');
        } else {
            // 変更がない場合はメッセージを表示
            return back()->with('info', '修正なし。変更がありませんでした。');
        }
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

    public function userUpdateStatus(Request $request)
    {
        Log::debug('リクエスト受信:', $request->all());

        $task = TaskList::where('id', $request->task_id)->first();
        Log::debug('取得したタスク:', ['task' => $task]);

        if (!$task) {
            return response()->json(['error' => 'タスクが見つかりません'], 404);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'ステータスを更新しました', 'status' => $task->status]);
    }

    public function UpdateStatus(Request $request)
    {
        Log::debug('リクエスト受信:', $request->all());

        $task = TaskList::where('id', $request->task_id)->first();
        Log::debug('取得したタスク:', ['task' => $task]);

        if (!$task) {
            return response()->json(['error' => 'タスクが見つかりません'], 404);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'ステータスを更新しました', 'status' => $task->status]);
    }

    public function deletedList()
    {
        $deletedTasks = TaskList::onlyTrashed()->paginate(10);
        // ユーザーを取得
        $users = User::select('id', 'name')->get();

        return view('task.deleted', compact('deletedTasks','users'));
    }

    public function restore($id)
    {
        $task = TaskList::onlyTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->back()->with('success', 'タスクを復元しました');
    }

    public function forceDelete($id)
    {
        $task = TaskList::onlyTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->back()->with('success', 'タスクを完全に削除しました');
    }



}
