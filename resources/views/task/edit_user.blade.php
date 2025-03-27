@extends('layouts.app')

@section('title', 'タスク管理一覧')

@section('vite')
    @vite(['resources/js/edit.js'])
@endsection

@section('header')
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <div class="tsk_tittle">
            <h1>タスク編集画面</h1>
        </div>
    </div>
@endsection
<!--メイン-->
@section('content')
<div class="main">
    <!--        レイアウト調整領域（メイン）-->
    <div class="main_edit_inner">
        <div class="button_area">
            <div class="nav">
                <!--            一覧画面遷移用ボタン-->
                <div class="allnemu_button">
                    <a href="{{ route('user.dashboard') }}" class="button back">タスク一覧へ戻る</a>
                </div>
                <div class="delete_area">
                    <form action="{{ route('user.dashboard.destroy', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('このタスクを削除しますか？')" class="button delete">削除</button>
                    </form>
                </div>
            </div>
        </div>
        <!--            タスク一覧表示領域-->
        <form action="{{ route('user.dashboard.update',$task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="edit_table">
                <table class="task">
                    <tr class="title">
                        <th>タスク名称</th>
                        <th>開始日</th>
                        <th>終了日</th>
                        <th>内容</th>
                        <th>進捗状況</th>
                        <th>更新ボタン</th>
                    </tr>
                    <tr class="tsk_content">
                        <td data-label="タスク名">
                            <input type="text" name="task_name" value="{{ $task->task_name }}">
                        </td>
                        <td data-label="開始日">
                            <input type="date" name="ymd_to" value="{{ $task->ymd_to }}">
                        </td>
                        <td data-label="終了日">
                            <input type="date" name="ymd_from" value="{{ $task->ymd_from }}">
                        </td>
                        <td data-label="タスク内容">
                            <input type="text" name="task_content" value="{{ $task->task_content }}">
                        </td>
                        <td data-label="ステータス">
                            <select name="status">
                                <option value=1 {{ $task->status == 1 ? 'selected' : '' }}>未着手</option>
                                <option value=2 {{ $task->status == 2 ? 'selected' : '' }}>対応中</option>
                                <option value=3 {{ $task->status == 3 ? 'selected' : '' }}>完了</option>
                            </select>
                        </td>
                        <td data-label="更新ボタン">
                            <input type="submit" value="更新" class="button update">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <div class="success">
            @if (session('success'))
                <p style="color: green;" class="success_message">{{ session('success') }}</p>
            @endif
            @if (session('info'))
                <p style="color: green;" class="success_message">{{ session('info') }}</p>
            @endif
        </div>
        @foreach (['task_name', 'task_content', 'ymd_to', 'ymd_from'] as $field)
            @error($field)
            <div class="error-message" style="color: red;">{{ $message }}</div>
            @enderror
        @endforeach


    </div>
</div>
@endsection
