<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // ユーザー一覧
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
