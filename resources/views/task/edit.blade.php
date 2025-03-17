<!doctype html>
<html lang=ja>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>編集・削除画面</title>
    {{--    <link rel="stylesheet" href="sanitize.css">--}}
    {{--    <link rel="stylesheet" href="style_edit.css">--}}
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
    <div class="main_inner">
        <!--            タスク一覧表示領域-->
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        <form action="{{ route('tasks.update',$task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="button_area">
                <!--            一覧画面遷移用ボタン-->
                <div class="allnemu_button">
                    <a href="{{ route('tasks.index') }}">タスク一覧へ戻る</a>
                </div>
                <div class="update_button">
                    <input type="submit" value="更新">
                </div>
            </div>
            <table class="task">
                <tr class="title">
                    <th>項番</th>
                    <th>タスク名称</th>
                    <th>開始日</th>
                    <th>終了日</th>
                    <th>内容</th>
                    <th>ユーザーID</th>
                    <th>進捗状況</th>
{{--                    <th>削除区分</th>--}}
                </tr>
{{--                @foreach ($task as $index => $tsk)--}}
{{--                @foreach ($task as $row)--}}
{{--                @dd($row);--}}
                <tr class="tsk_content">
                    <td>
                        <!-- ID を表示（編集不可） -->
                        <input type="text"  name="id" value="{{ $task->id }}" readonly>
{{--                        @dd($task->id);--}}
                        <!-- ID を隠しフィールドとしても送信 -->
                        <input type="hidden"  name="id_hidden" value="{{ $task->id }}">
                    </td>
                    <td>
                        <input type="text" name="task_name" value="{{ $task->task_name }}">
                    </td>
                    <td>
                        <input type="date" name="ymd_to" value="{{ $task->ymd_to }}">
                    </td>
                    <td>
                        <input type="date" name="ymd_from" value="{{ $task->ymd_from }}">
                    </td>
                    <td>
                        <input type="text" name="task_content" value="{{ $task->task_content }}">
                    </td>
                    <td>
                        <input type="text" name="user_id" value="{{ $task->user_id }}">
                    </td>
                    <td>
{{--                        <input type="text" value="{{ $task->status }}">--}}
                        <select name="status">
{{--                            @dd($tsk);--}}
                            <option value=1 {{ $task->status == 1 ? 'selected' : '' }}>未着手</option>
                            <option value=2 {{ $task->status == 2 ? 'selected' : '' }}>対応中</option>
                            <option value=3 {{ $task->status == 3 ? 'selected' : '' }}>完了</option>
                        </select>
                    </td>
                    <td>
{{--                        <input type="text" value="{{ $task->deleted_at }}">--}}
{{--                        <select>--}}
{{--                            <option value=0 {{ $task->deleted_at == 0 ? 'selected' : '' }}>有効</option>--}}
{{--                            <option value=1 {{ $task->deleted_at == 1 ? 'selected' : '' }}>削除</option>--}}
{{--                        </select>--}}
                    </td>
                </tr>
{{--                @endforeach--}}
{{--                <tr class="tsk_content">--}}
{{--                    <td>--}}
{{--                        <!-- ID を表示（編集不可） -->--}}
{{--                        <!--                        <input type="text" name="tasks" placeholder="ID">-->--}}
{{--                        <!-- ID を隠しフィールドとしても送信 -->--}}
{{--                        <!--                        <input type="hidden" name="tasks" value="ID">-->--}}
{{--                        <input type="text" name="newID" placeholder="ID" readonly>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input type="text" name="newname" placeholder="タスク名称を入力してください">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input type="date" name="newdateto">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input type="date" name="newdatefrom">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input type="text" name="newtasks" placeholder="タスクの詳細を入力してください">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select name="newstatus">--}}
{{--                            <option value=1 >未着手</option>--}}
{{--                            <option value=2 >対応中</option>--}}
{{--                            <option value=3 >完了</option>--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select name="newdelflg">--}}
{{--                            <option value=0 >有効</option>--}}
{{--                            <option value=1 >削除</option>--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                </tr>--}}
            </table>
        </form>
{{--        <form action="#">--}}
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('このタスクを削除しますか？')">削除</button>
        </form>
    </div>
</div>
<footer>

</footer>
{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function () {--}}
{{--        document.querySelectorAll("select[name$='[status]']").forEach(select => {--}}
{{--            select.addEventListener("change", function () {--}}
{{--                const taskRow = this.closest("tr"); // 選択された行の `<tr>` を取得--}}
{{--                const taskId = taskRow.querySelector("input[name$='[id_hidden]']").value; // 隠しID取得--}}
{{--                const newStatus = this.value; // 新しいステータス値を取得--}}

{{--                console.log("送信するID:", taskId);--}}
{{--                console.log("送信する新ステータス:", newStatus);--}}
{{--                console.log("this:", this);--}}
{{--                console.log("親要素:", this.parentElement);--}}
{{--                console.log("祖先要素:", this.closest("tr"));--}}
{{--                console.log("taskRow:", taskRow);--}}

{{--                // 送信データを作成--}}
{{--                const formData = new FormData();--}}
{{--                formData.append("id", taskId);--}}
{{--                formData.append("status", newStatus);--}}

{{--                // 非同期通信でデータを送信--}}
{{--                fetch("update_status.php", {--}}
{{--                    method: "POST",--}}
{{--                    body: formData--}}
{{--                })--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        console.log("サーバーからのレスポンス:", data);--}}
{{--                        if (data.success) {--}}
{{--                            alert("ステータスの更新を行いました。");--}}
{{--                        } else {--}}
{{--                            alert("ステータスの更新に失敗しました。");--}}
{{--                            console.error("エラー詳細:", data);--}}
{{--                        }--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error("通信エラー:", error);--}}
{{--                        alert("通信エラーが発生しました。");--}}
{{--                    });--}}
{{--            });--}}
{{--        });--}}
{{--        document.querySelectorAll("input[type='date']").forEach(input => {--}}
{{--            input.addEventListener("change", function() {--}}
{{--                const datePattern = /^\d{4}\/\d{2}\/\d{2}$/; // yyyy/mm/dd フォーマット--}}
{{--                const value = this.value.replace(/-/g, "/"); // ハイフンをスラッシュに変換--}}

{{--                if (!datePattern.test(value)) {--}}
{{--                    alert("日付は yyyy/mm/dd の形式で入力してください。");--}}
{{--                    this.value = ""; // 入力をクリア--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>
