{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    @vite(['resources/js/app.js'])--}}
{{--    @vite(['resources/js/store.js'])--}}
{{--    <title>Document</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<header>--}}
@extends('layouts.app')

@section('title', 'タスク管理一覧')

@section('vite')
    @vite(['resources/js/store.js'])
@endsection

@section('header')
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <div class="tsk_tittle">
            <h1>タスク新規登録画面</h1>
        </div>
    </div>
@endsection
{{--</header>--}}
@section('content')
{{--<main>--}}
    <div class="main_edit_inner">
        <div class="success">
            @if (session('success'))
                <p style="color: green;" class="success_message">{{ session('success') }}</p>
            @endif
        </div>
        <form action="{{ route('user.dashboard.store') }}" method="POST">
            @csrf
            @foreach (['task_name', 'task_content', 'ymd_to', 'ymd_from'] as $field)
                @error($field)
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            @endforeach
            <div class="button_area">
                <div class="nav">
                    <div class="allnemu_button">
                        <a href="{{ route('user.dashboard') }}" class="button back">タスク一覧へ戻る</a>
                    </div>
                </div>
            </div>
            <div class="edit_table">
                <table class="task">
                    <tr class="title">
                        <th>タスク名称</th>
                        <th>開始日</th>
                        <th>終了日</th>
                        <th>内容</th>
                        <th>進捗状況</th>
                        <th>登録ボタン</th>
                    </tr>
                    <tr class="tsk_content">
                        <td data-label="タスク名称">
                            <input type="text" name="task_name" placeholder="タスク名称を入力してください" required>
                        </td>
                        <td data-label="開始日">
                            <input type="date" name="ymd_to" required>
                        </td>
                        <td data-label="終了日">
                            <input type="date" name="ymd_from" required>
                        </td>
                        <td data-label="内容">
                            <input type="text" name="task_content" placeholder="タスクの詳細を入力してください" required>
                        </td>
                        <td data-label="進捗状況">
                            <select name="status">
                                <option value=1 >未着手</option>
                                <option value=2 >対応中</option>
                                <option value=3 >完了</option>
                            </select>
                        </td>
                        <td data-label="登録ボタン">
                            <button type="submit">登録</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
@endsection
{{--</main>--}}
{{--</body>--}}
{{--</html>--}}
