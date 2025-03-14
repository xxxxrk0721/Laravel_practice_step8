<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>管理</title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            text-align: right;
        }

        /*.admin_register {*/
        /*    width: 50px;*/
        /*    height: 50px;*/
        /*}*/
        a {
            color: black;
            /*line-height: normal;*/
        }
    </style>
</head>

<body>
<main>
    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <div>
            <label for="email">メールアドレス: </label>
            <input type="email" id="email" name="email" required />
        </div>
        <div>
            <label for="password">パスワード: </label>
            <input type="password" id="password" name="password" required />
        </div>
        <div>
            @error('failed')
            <p style="color:red">{{ $message }}</p>
            @enderror
            <button type="submit">ログイン</button>
        </div>
    </form>
    <div class="admin_register">
        <a href="{{ route('admin.register') }}">新規登録</a>
    </div>
    <div>
        <a href="{{ url('/') }}">トップページへ戻る</a>
    </div>
</main>
</body>
</html>
