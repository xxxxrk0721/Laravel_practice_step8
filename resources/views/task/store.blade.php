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
    <main>
        <h1>タスクしんき登録画面</h1>
        <div class="allnemu_button">
            <a href="{{ route('tasks.index') }}">タスク一覧へ戻る</a>
        </div>
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
        <table>
            <tr class="title">
                <th>項番</th>
                <th>タスク名称</th>
                <th>開始日</th>
                <th>終了日</th>
                <th>内容</th>
                <th>ユーザーID</th>
                <th>進捗状況</th>
{{--                <th>削除区分</th>--}}
            </tr>
            <tr class="tsk_content">
                <td>
                    <!-- ID を表示（編集不可） -->
                    <!--                        <input type="text" name="tasks" placeholder="ID">-->
                    <!-- ID を隠しフィールドとしても送信 -->
                    <!--                        <input type="hidden" name="tasks" value="ID">-->
                    <input type="text" name="id" placeholder="ID" readonly>
                </td>
                <td>
                    <input type="text" name="task_name" placeholder="タスク名称を入力してください">
                </td>
                <td>
                    <input type="date" name="ymd_to">
                </td>
                <td>
                    <input type="date" name="ymd_from">
                </td>
                <td>
                    <input type="text" name="task_content" placeholder="タスクの詳細を入力してください">
                </td>
                <td>
                    <input type="text" name="user_id" placeholder="ユーザーIDを入力してください">
                </td>
                <td>
                    <select name="status">
                        <option value=1 >未着手</option>
                        <option value=2 >対応中</option>
                        <option value=3 >完了</option>
                    </select>
                </td>
{{--                <td>--}}
{{--                    <select name="deleted_at">--}}
{{--                        <option value=0 >有効</option>--}}
{{--                        <option value=1 >削除</option>--}}
{{--                    </select>--}}
{{--                </td>--}}
            </tr>
        </table>
        <button type="submit">登録</button>
        </form>
    </main>
</body>
</html>
