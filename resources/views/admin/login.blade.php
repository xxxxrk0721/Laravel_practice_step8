{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8" />--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1" />--}}
{{--    <title>管理</title>--}}
{{--    @vite(['resources/js/app.js'])--}}
{{--    <style>--}}
{{--    </style>--}}
{{--</head>--}}
@include('layouts.head')
<body>
    <main class="login">
        <div class="login_inner">
            <div class="title">
                <h1>管理者用ログイン画面</h1>
            </div>
            <div class="nav">
                <div class="admin_register">
                    <a href="{{ route('admin.register') }}" class="button admin">新規登録</a>
                </div>
                <div>
                    <a href="{{ url('/') }}" class="button back">トップページへ戻る</a>
                </div>
            </div>
            <div class="access_form">
                <form method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <div class="form">
                        <div>
                            <label for="email">メールアドレス</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required />
                        </div>
                        <div>
                            <label for="password">パスワード</label>
                            <input type="password" id="password" name="password" required />
                        </div>
                    </div>
                    <div class="login_button">
                        <button type="submit" class="button login">ログイン</button>
                    </div>
                </form>
            </div>
            @error('failed')
            <p style="color:red">{{ $message }}</p>
            @enderror
        </div>
    </main>
</body>
</html>
