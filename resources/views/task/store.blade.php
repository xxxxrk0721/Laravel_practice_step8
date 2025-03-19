<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <title>Document</title>
</head>
<body>
<header>
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <div class="tsk_tittle">
            <h1>タスク新規登録画面</h1>
        </div>
    </div>
</header>
<main>
    <div class="main_edit_inner">
        <div class="success">
            @if (session('success'))
                <p style="color: green;" class="success_message">{{ session('success') }}</p>
            @endif
        </div>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
{{--            @error('task_name')--}}
{{--            <div class="error-message" style="color: red;">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--            @error('task_content')--}}
{{--            <div class="error-message" style="color: red;">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--            @error('ymd_to')--}}
{{--            <div class="error-message" style="color: red;">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--            @error('ymd_from')--}}
{{--            <div class="error-message" style="color: red;">{{ $message }}</div>--}}
{{--            @enderror--}}
            @foreach (['task_name', 'task_content', 'ymd_to', 'ymd_from'] as $field)
                @error($field)
                <div class="error-message" style="color: red;">{{ $message }}</div>
                @enderror
            @endforeach
            <div class="button_area">
                <div class="nav">
                    <div class="allnemu_button">
                        <a href="{{ route('tasks.index') }}" class="button back">タスク一覧へ戻る</a>
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
                        <th>ユーザーID</th>
                        <th>進捗状況</th>
                        <th>登録ボタン</th>
                    </tr>
                    <tr class="tsk_content">
                        <td>
                            <input type="text" name="task_name" placeholder="タスク名称を入力してください" required>
                        </td>
                        <td>
                            <input type="date" name="ymd_to" required>
                        </td>
                        <td>
                            <input type="date" name="ymd_from" required>
                        </td>
                        <td>
                            <input type="text" name="task_content" placeholder="タスクの詳細を入力してください" required>
                        </td>
                        <td>
                            <select name="user_id" id="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} (ID: {{ $user->id }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="status">
                                <option value=1 >未着手</option>
                                <option value=2 >対応中</option>
                                <option value=3 >完了</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit">登録</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</main>
</body>
</html>
