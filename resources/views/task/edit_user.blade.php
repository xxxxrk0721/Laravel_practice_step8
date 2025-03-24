<!doctype html>
<html lang=ja>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>編集・削除画面</title>
    @vite(['resources/js/edit.js'])
</head>
<body>
<!--ヘッダー-->
<header>
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <div class="tsk_tittle">
            <h1>タスク編集画面</h1>
        </div>
    </div>
</header>
<!--メイン-->
<div class="main">
    <!--        レイアウト調整領域（メイン）-->
    <div class="main_edit_inner">
        <!--            タスク一覧表示領域-->
        <form action="{{ route('user.dashboard.update',$task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="button_area">
                <div class="nav">
                    <!--            一覧画面遷移用ボタン-->
                    <div class="allnemu_button">
                        <a href="{{ route('user.dashboard') }}" class="button back">タスク一覧へ戻る</a>
                    </div>
                    <div class="update_button_user">
                        <input type="submit" value="更新" class="button update">
                    </div>
                </div>
            </div>
            <div class="edit_table">
                <table class="task">
                    <tr class="title">
{{--                        <th>項番</th>--}}
                        <th>タスク名称</th>
                        <th>開始日</th>
                        <th>終了日</th>
                        <th>内容</th>
{{--                        <th>ユーザーID</th>--}}
                        <th>進捗状況</th>
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
                    </tr>
                </table>
            </div>
        </form>
        <div class="delete_area">
            <form action="{{ route('user.dashboard.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('このタスクを削除しますか？')" class="button delete">削除</button>
            </form>
        </div>
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
<footer>

</footer>
</body>
</html>
