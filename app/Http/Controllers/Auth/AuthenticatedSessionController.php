<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('tasks.index'));
//        return redirect()->intended(RouteServiceProvider::HOME);
//        return redirect()->intended(route('tasks.index'));
//        return redirect('/');
    }

//    public function index(Request $request)
//    {
//        // 現在ログインしているユーザーの ID を取得
//        $userId = Auth::guard('users')->id();
//
//        $query = DB::table('task_lists')
//            ->where('user_id', $userId)
//            ->whereNull('deleted_at');
//
//        if ($request->filled('status')) {
//            $query->where('status', $request->status);
//        }
//
//        // 検索キーワードが送信された場合（タスク名で検索）
//        if ($request->filled('task_name')) {
//            $query->where('task_name', 'like', '%' . $request->task_name . '%');
//        }
//
//        // 検索キーワードが送信された場合（日付で検索）
//        if ($request->filled('ymd_to')) {
//            $query->where('ymd_to',$request->ymd_to);
//        }
//
//        // 検索キーワードが送信された場合（日付で検索）
//        if ($request->filled('ymd_from')) {
//            $query->where('ymd_from', $request->ymd_from);
//        }
//
//        // ユーザーID
//        if ($request->filled('user_id')) {
//            $query->where('user_id', 'like', '%' . $request->user_id . '%');
//        }
//        $tasks = $query->paginate(10);
//        // 検索結果をビューに渡す
//        return view('admin.top', compact('tasks'));
//    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
//        Auth::guard('web')->logout();
        Auth::guard('users')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
