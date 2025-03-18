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
<main class="register">
    <div class="register_inner">
        <div class="title">
            <h1>ユーザー用登録画面</h1>
        </div>
        <div class="nav">
            <div>
                <a href="{{ url('/') }}" class="button back">トップページへ戻る</a>
            </div>
        </div>
        <div class="access_form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form">
                <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('名前')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('メールアドレス')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('パスワード')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('パスワード※再入力')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="login_button">

                    <x-primary-button class="button login">
                        {{ __('登録') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</main>
