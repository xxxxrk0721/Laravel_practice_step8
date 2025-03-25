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
        <!--            編集画面遷移用ボタン-->
        <div class="tsk_tittle">
            <h1>削除済一覧(管理者用)</h1>
        </div>
        <div class="success">
            @if (session('success'))
                <p style="color: green;" class="success_message">{{ session('success') }}</p>
            @endif
        </div>
    </div>
</header>
<!--メイン-->
<main>
    <div class="main">
        <!--        レイアウト調整領域（メイン）-->
        <div class="main_inner">
            <!--            タスク一覧表示領域-->
            <div class="search">
                <!--                ステータス検索-->
                <div class="button_area">
                    <div class="nav">
                        <div class="allnemu_button">
                            <a href="{{ route('tasks.index') }}" class="button back">タスク一覧へ戻る</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search_list">
                <form action="{{ route('tasks.deletedList') }}" method="GET" class="list">
                    @csrf

                    <table class="task">
                        <tr class="title">
                            <th class="id">項番</th>
                            <th class="tsk_nm">タスク名称</th>
                            <th class="start">開始日▼▲</th>
                            <th class="end">終了日▼▲</th>
                            <th class="tsk">内容</th>
                            <th class="state">進捗状況</th>
                            <th class="user_id">ユーザー名(ID)</th>
                            <th>復元ボタン</th>
                            <th>完全削除ボタン</th>
                        </tr>
                        @foreach ($deletedTasks as $row)

                            <tr class="tsk_content">
                                <td class="mobile_only" data-label="ユーザー名">
                                    @foreach ($users as $user)
                                        @if ($row->user_id == $user->id)
                                            <p>{{ $user->name }} (ID: {{ $user->id }})</p>
                                        @endif
                                    @endforeach
                                </td>
                                <!-- idの表示 -->
                                <td class="id detail" data-label="ID">{{ $row->id }}</td>

                                <!-- task_nameの表示 -->
                                <td class="tsk_nm detail" data-label="タスク名">{{ $row->task_name }}</td>

                                <!-- ymd_toの表示 -->
                                <td class="start detail" data-label="開始日">{{ $row->ymd_to }}</td>

                                <!-- ymd_fromの表示 -->
                                <td class="end detail" data-label="終了日">{{ $row->ymd_from }}</td>

                                <!-- task_contentの表示 -->
                                <td class="tsk detail" data-label="タスク内容">{{ $row->task_content }}</td>

                                <!-- statusの表示 -->
                                <td class="state detail" data-label="ステータス">
                                    @switch($row->status)
                                        @case(1)
                                            未着手
                                            @break
                                        @case(2)
                                            対応中
                                            @break
                                        @case(3)
                                            完了
                                            @break
                                        @default
                                            不明
                                    @endswitch

                                </td>
                                <td class="user_id user_title" data-label="ユーザーID">
                                    @foreach ($users as $user)
                                        @if ($row->user_id == $user->id)
                                            <p>{{ $user->name }} (ID: {{ $user->id }})</p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="detail" data-label="復元ボタン">
                                    <form method="POST" action="{{ route('tasks.restore',['id' => $row->id]) }}">
                                        @csrf
                                        <button type="submit">復元</button>
                                    </form>
                                </td>
                                <td class="detail" data-label="完全削除ボタン">
                                    <form method="POST" action="{{ route('tasks.forceDelete',['id' => $row->id]) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirm('完全に削除しますか？')">完全削除</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </table>
                    {{ $deletedTasks->appends(request()->query())->links('vendor.pagination.default') }}
                </form>
            </div>
        </div>
    </div>
</main>
<!--フッター-->
<footer>

</footer>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mobile_only').forEach(function (taskNameCell) {
            taskNameCell.addEventListener('click', function () {
                const row = this.closest('.tsk_content');
                row.classList.toggle('open');
            });
        });
    });
</script>
</body>
</html>
