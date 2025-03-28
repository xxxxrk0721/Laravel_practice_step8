@extends('layouts.app')

@section('title', 'タスク管理一覧')

@section('vite')
    @vite(['resources/js/store.js'])
@endsection

@section('header')
    <div class="header_inner">
        <div class="button_area">
            <div class="nav">
                <div class="allnemu_button">
                    <a href="{{ route('tasks.index') }}" class="button back">タスク一覧へ戻る</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="main_edit_inner">
        <div class="tsk_tittle">
            <h2>タスク新規登録画面</h2>
        </div>
        <x-task-success-message />
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <x-task-store-error />
            <div class="edit_table">
                <table class="task">
                    <tr class="title">
                        <th>タスク名称</th>
                        <th>開始日</th>
                        <th>終了日</th>
                        <th>内容</th>
                        <th>ユーザーID</th>
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
                        <td data-label="ユーザーID">
                            <select name="user_id" id="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} (ID: {{ $user->id }})
                                    </option>
                                @endforeach
                            </select>
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
