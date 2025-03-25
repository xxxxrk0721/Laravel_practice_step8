<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>管理</title>
    @vite(['resources/js/index.js'])

    <style>
{{--        @vite('resources/sass/index.scss')--}}
    </style>
</head>

<body>
<!--ヘッダー-->
<header>
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <!--            編集画面遷移用ボタン-->
        <div class="tsk_tittle">
            <h1>業務進捗ダッシュボード</h1>
            <h2>ようこそ {{ $users->name }} さん</h2>
        </div>
        <div class="success">
            @if (session('success'))
                <p style="color: green;" class="success_message">{{ session('success') }}</p>
            @endif
        </div>
        @foreach (['ymd_to', 'ymd_from'] as $field)
            @error($field)
            <div class="error-message" style="color: red;">{{ $message }}</div>
            @enderror
        @endforeach
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
                        <form method="POST" action="{{ route('login.destroy') }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="button back">ログアウト</button>
                        </form>
                        <div class="new_button">
                            <!--            検索画面遷移用ボタン-->
                            <div class="edit_button">
                                <a href="{{ route('user.dashboard.store') }}" class="button register">タスク新規登録</a>
                            </div>
                        </div>
                        <div class="humburger_btn">
                            <button class="menu_button">☰</button> <!-- ハンバーガーメニュー -->
                        </div>
                    </div>
                </div>
                <div class="search_area">
                    <form action="{{ route('user.dashboard') }}" method="GET" class="search_form">
                        @csrf
                        <div class="search_box">
                            <div class="status_name">
                                ステータス:
                                <select name="status">
                                    <option value="">すべてのステータス</option>
                                    <option value=1 {{ request('status') == "1" ? 'selected' : '' }}>未着手</option>
                                    <option value=2 {{ request('status') == "2" ? 'selected' : '' }}>対応中</option>
                                    <option value=3 {{ request('status') == "3" ? 'selected' : '' }}>完了</option>
                                </select>
                            </div>

                            <!--                タスク名検索-->
                            <div class="tsk_name">
                                タスク名称:<input type="text" name="task_name" value="{{ request('task_name') }}" placeholder="タスク名を検索">
                            </div>

                            <!--                日付検索-->
                            <div class="ymd_name">
                                開始日:
                                <input type="date" name="ymd_to" value="{{ request('ymd_to') }}">
                            </div>

                            <div class="ymd_name">
                                終了日:<input type="date" name="ymd_from" value="{{ request('ymd_from') }}">
                            </div>

                            <input type="submit" value="検索" class="submit_button">
                        </div>
                    </form>
                </div>
            </div>
            <div class="search_list">
                <form action="{{ route('user.dashboard') }}" method="GET" class="list">
                    @csrf

                    <table class="task">
                        <tr class="title">
{{--                            <th class="id">項番</th>--}}
                            <th class="tsk_nm">タスク名称</th>
                            <th class="start">開始日▼▲</th>
                            <th class="end">終了日▼▲</th>
                            <th class="tsk">内容</th>
                            <th class="state">進捗状況</th>
                            <th class="user_id">編集ボタン</th>
                        </tr>
                        @if ($tasks->count() > 0)
                            @foreach ($tasks as $row)

                                <tr class="tsk_content
                                    @if($row->due_status === 'overdue' && $row->status <> 3) overdue
                                    @elseif($row->due_status === 'near' && $row->status <> 3) near-deadline
                                    @endif">
                                    <!-- idの表示 -->
                                    <!-- task_nameの表示 -->
                                    <td class="tsk_nm task-name" data-label="タスク名">{{ $row->task_name }}</td>

                                    <!-- ymd_toの表示 -->
                                    <td class="start detail" data-label="開始日">{{ $row->ymd_to }}</td>

                                    <!-- ymd_fromの表示 -->
                                    <td class="end detail" data-label="終了日">{{ $row->ymd_from }}</td>

                                    <!-- task_contentの表示 -->
                                    <td class="tsk detail" data-label="タスク内容">{{ $row->task_content }}</td>

                                    <!-- statusの表示 -->
                                    <td class="status detail" data-label="ステータス">
                                        <select class="status-select" data-task-id="{{ $row->id }}">

                                            <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>未着手</option>
                                            <option value="2" {{ $row->status == 2 ? 'selected' : '' }}>対応中</option>
                                            <option value="3" {{ $row->status == 3 ? 'selected' : '' }}>完了</option>
                                        </select>

                                    </td>
                                    <td class="detail" data-label="編集ボタン">
                                        <a href="{{ route('user.dashboard.edit',['id' => $row->id])  }}" class="table-btn">編集</a>
                                    </td>
                                </tr>

                            @endforeach
                        @else
                            <p>対象のデータがありません。</p>
                        @endif
                    </table>
                    {{ $tasks->appends(request()->query())->links('vendor.pagination.default') }}

                </form>
{{--                <p>{{route('user.dashboard.updateStatus')}}</p>--}}
            </div>
        </div>
    </div>
</main>
<!--フッター-->
<footer>

</footer>
<script>
    // 日付順ソート
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

    // ステータスの更新
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
                let taskId = this.getAttribute('data-task-id');
                let newStatus = this.value;

                fetch("{{ route('user.dashboard.updateStatus') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        task_id: taskId,
                        status: newStatus
                    })
                })
                    .then(response => response.json())
                    // .then(response => response.text())
                    .then(data => {
                        console.log(data); // ← 一度確認！
                        alert(data.message);
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const menuButton = document.querySelector(".menu_button");
        const searchArea = document.querySelector(".search_area");

        menuButton.addEventListener("click", function() {
            searchArea.classList.toggle("active"); // クラスの追加・削除で表示を切り替え
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.task-name').forEach(function (taskNameCell) {
            taskNameCell.addEventListener('click', function () {
                const row = this.closest('.tsk_content');
                row.classList.toggle('open');
            });
        });
    });
</script>
</body>
</html>
