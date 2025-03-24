<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="header_inner">
            <div class="tsk_tittle">
                <h1>登録ユーザー一覧</h1>
            </div>
        </div>
    </header>
    <main>
        <div class="main">
            <div class="main_inner">
                <div class="user_list">
                    <table class="user">
                        <tr class="">
                            <th class="id">タスク名称</th>
                            <th class="name">開始日▼▲</th>
                            <th class="email">終了日▼▲</th>
                        </tr>
                        @foreach ($tasks as $row)
                            <tr class="id">
                                <!-- task_nameの表示 -->
                                <td class="name">{{ $row->task_name }}</td>

                                <!-- ymd_toの表示 -->
                                <td class="emil">{{ $row->ymd_to }}</td>
                            </tr>
                      @endforeach
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>
