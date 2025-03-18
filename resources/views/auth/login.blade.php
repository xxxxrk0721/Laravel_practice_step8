<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>管理</title>
    @vite(['resources/js/app.js'])
    <style>
    </style>
</head>
<body>
    <main class="login">
        <div class="login_inner">
{{--<x-guest-layout>--}}
    <!-- Session Status -->
{{--        <x-auth-session-status class="mb-4" :status="session('status')" />--}}
            <div class="title">
                <h1>ユーザー用ログイン画面</h1>
            </div>
            <div class="nav">
                <div class="register">
                    <a href="{{ route('register') }}">新規登録</a>
                </div>
                <div>
                    <a href="{{ url('/') }}">トップページへ戻る</a>
                </div>
            </div>
            <div class="access_form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form">
                        <!-- Email Address -->
                        <div>
        {{--                    <x-input-label for="email" :value="__('メールアドレス：')" />--}}
        {{--                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}
                            <label for="email">メールアドレス：</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('パスワード：')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>
                    <!-- Remember Me -->
        {{--            <div class="block mt-4">--}}
        {{--                <label for="remember_me" class="inline-flex items-center">--}}
        {{--                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">--}}
        {{--                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
        {{--                </label>--}}
        {{--            </div>--}}

        {{--            <div class="flex items-center justify-end mt-4">--}}
        {{--                @if (Route::has('password.request'))--}}
        {{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
        {{--                        {{ __('Forgot your password?') }}--}}
        {{--                    </a>--}}
        {{--                @endif--}}

        {{--                <x-primary-button class="ms-3">--}}
        {{--                    {{ __('ログイン') }}--}}
        {{--                </x-primary-button>--}}
        {{--            </div>--}}
                    <div class="login_button">
        {{--                @error('failed')--}}
        {{--                <p style="color:red">{{ $message }}</p>--}}
        {{--                @enderror--}}
                        <button type="submit">ログイン</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
{{--</x-guest-layout>--}}
