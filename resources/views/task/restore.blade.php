<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/delete.js'])
    <title>タスク管理一覧</title>
</head>
<body>
<!--ヘッダー-->
<header>
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <h2>タスクの復元</h2>
    </div>
</header>
<!--メイン-->
<main>
    <div class="main">
        <!--        レイアウト調整領域（メイン）-->
        <div class="main_inner">
            <div class="button_area">
                <div class="nav">
                    <div class="allnemu_button">
                        <a href="{{ route('tasks.deletedList') }}" class="button back">削除一覧へ戻る</a>
                    </div>
                </div>
            </div>
            <!--            タスク一覧表示領域-->
            <div class="search_list">
                <div class="container">


                    <p>以下のタスクを復元しますか？</p>

                    <table>
                        <tr>
                            <td>タスク名:</td>
                            <td>{{ $task->task_name }}</td>
                        </tr>
                        <tr>
                            <td>開始日:</td>
                            <td>{{ $task->ymd_to }}</td>
                        </tr>
                        <tr>
                            <td>終了日:</td>
                            <td>{{ $task->ymd_from }}</td>
                        </tr>
                        <tr>
                            <td>内容:</td>
                            <td>{{ $task->task_content }}</td>
                        </tr>
                    </table>

                    <!-- 復元ボタン -->
                    <form method="POST" action="{{ route('tasks.restore', $task->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">復元</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!--フッター-->
<footer>

</footer>

</body>
</html>
