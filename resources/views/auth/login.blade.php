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
{{--<x-head title="ユーザー管理" />--}}
@include('layouts.head')
<body>
    <main class="login">
        <div class="login_inner">
            <div class="title">
                <h1>ユーザー用ログイン画面</h1>
            </div>
            <div class="nav">
                <div class="user_register">
                    <a href="{{ route('register') }}" class="button register">新規登録</a>
                </div>
                <div>
                    <a href="{{ url('/') }}" class="button back">トップページへ戻る</a>
                </div>
            </div>
            <div class="access_form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form">
                        <div>
                            <label for="email">メールアドレス</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('パスワード')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                        </div>
                    </div>
                    <div class="login_button">
                        <button type="submit" class="button login">ログイン</button>
                    </div>
                </form>
            </div>
            @if ($errors->has('email'))
                <div class="error-message">
                    <p style="color:red">{{ $errors->first('email') }}</p>
                </div>
            @endif
        </div>
    </main>
</body>
{{--</x-guest-layout>--}}
