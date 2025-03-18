<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <title>タスク管理一覧</title>
</head>
<body>
<!--ヘッダー-->
<header>
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <!--            編集画面遷移用ボタン-->
        <div class="tsk_tittle">
            <h1>業務進捗ダッシュボード(管理者用)</h1>
        </div>
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

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
    {{--            <form method="POST" action="{{ route('admin.login.destroy') }}">--}}
                <div class="button_area">
                    <div class="nav">
                        <form method="POST" action="{{ route('admin.login.destroy') }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                        <div class="button_area">
                            <div class="edit_button">
                                {{--                    <input type="submit" value="タスク登録">--}}
                                <a href="{{ route('tasks.store') }}">タスク新規登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search_area">
                <form action="{{ route('tasks.index') }}" method="GET" class="search_form">
                    @csrf
                    <div class="status_name">
                        <p>ステータス:</p>
                    </div>
                    <select name="status">
                        <option value="">すべてのステータス</option>
                        <option value=1 {{ request('status') == "1" ? 'selected' : '' }}>未着手</option>
                        <option value=2 {{ request('status') == "2" ? 'selected' : '' }}>対応中</option>
                        <option value=3 {{ request('status') == "3" ? 'selected' : '' }}>完了</option>
                    </select>
                    <!--                タスク名検索-->
                    <div class="tsk_name">
                        <p>タスク名称:</p>
                    </div>
                    <input type="text" name="task_name" value="{{ request('task_name') }}" placeholder="タスク名を検索">
                    <!--                日付検索-->
                    <div class="ymd_name">
                        <p>開始日:</p>
                    </div>
                    <input type="date" name="ymd_to" value="{{ request('ymd_to') }}">
    {{--                <input type="date" name="ymd_to" value="">--}}
                    <div class="ymd_name">
                        <p>終了日:</p>
                    </div>
                    <input type="date" name="ymd_from" value="{{ request('ymd_from') }}">
    {{--                <input type="date" name="end_ymd_search" value="">--}}
                    <div>
                        <p>ユーザーID</p>
                    </div>
    {{--                <input type="text" name="user_id" value="">--}}
                    <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="ユーザーIDを検索">
                    <input type="submit" value="検索">
                </form>
                </div>
            </div>
            <div class="search_list">
                <form action="{{ route('tasks.index') }}" method="GET" class="list">
                    @csrf
                    <div class="button_area">
                        <!--            検索画面遷移用ボタン-->
        {{--                <div class="search_button">--}}
        {{--                    <a href="{{ route('tasks.index') }}">タスク検索</a>--}}
        {{--                </div>--}}
        {{--                <div class="edit_button">--}}
        {{--                    <input type="submit" value="タスク登録">--}}
        {{--                    <a href="{{ route('tasks.store') }}">タスク新規登録</a>--}}
        {{--                </div>--}}
                    </div>
                    <table class="task">
                        <tr class="title">
                            <th class="id">項番</th>
                            <th class="tsk_nm">タスク名称</th>
                            <th class="start">開始日▼▲</th>
                            <th class="end">終了日▼▲</th>
                            <th class="tsk">内容</th>
                            <th class="state">進捗状況</th>
                            <th class="user_id">ユーザー名(ID)</th>
                            <th class="user_id">編集ボタン</th>
                        </tr>
        {{--                @dd($tasks);--}}
                        @foreach ($tasks as $row)

                        <tr class="tsk_content">
                            <!-- idの表示 -->
                            <td class="id">{{ $row->id }}</td>

                            <!-- task_nameの表示 -->
                            <td class="tsk_nm">{{ $row->task_name }}</td>

                            <!-- ymd_toの表示 -->
                            <td class="start">{{ $row->ymd_to }}</td>

                            <!-- ymd_fromの表示 -->
                            <td class="end">{{ $row->ymd_from }}</td>

                            <!-- task_contentの表示 -->
                            <td class="tsk">{{ $row->task_content }}</td>

                            <!-- statusの表示 -->
                            <td class="state">
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
                            <td class="user_id">
                                @foreach ($users as $user)
                                    @if ($row->user_id == $user->id)
                                        <p>{{ $user->name }} (ID: {{ $user->id }})</p>
                                    @endif
                                @endforeach
{{--                                {{ $row->user_id }}--}}
                            </td>
                            <td>
                                <a href="{{ route('tasks.edit',['id' => $row->id])  }}">編集</a>
                            </td>
                        </tr>

                        @endforeach
                    </table>
                    {{ $tasks->appends(request()->query())->links('vendor.pagination.default') }}
        {{--            {{ $tasks->links('vendor.pagination.default') }}--}}


                </form>
            </div>
        </div>
    </div>
</main>
<!--フッター-->
<footer>

</footer>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let sortOrder = 1; // 1: 昇順, -1: 降順

        function sortTable(columnClass) {
            const table = document.querySelector(".task");
            const tbody = table.querySelector("tbody") || table; // `tbody` がない場合、`table` で処理
            const rows = Array.from(tbody.querySelectorAll(".tsk_content"));

            // ソート処理
            rows.sort((rowA, rowB) => {
                let dateA = new Date(rowA.querySelector("." + columnClass).textContent.trim());
                let dateB = new Date(rowB.querySelector("." + columnClass).textContent.trim());

                return (dateA - dateB) * sortOrder;
            });

            // ソート順を逆にする（昇順⇔降順）
            sortOrder *= -1;

            // テーブルのデータを並び替え
            rows.forEach(row => tbody.appendChild(row));
        }

        // クリックイベントを設定
        document.querySelector(".start").addEventListener("click", function () {
            sortTable("start");
        });
        document.querySelector(".end").addEventListener("click", function () {
            sortTable("end");
        });
    });
</script>

</body>
</html>
