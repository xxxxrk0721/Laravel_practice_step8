<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', '管理者ログイン')</title>
{{--    @vite(['resources/js/app.js'])--}}
    @hasSection('vite')
        @yield('vite')
    @else
        @vite(['resources/js/app.js'])
    @endif

    <style>
        @stack('styles')
        body {
            font-family: 'メイリオ', 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif;
            /*font-family: 'Courier New', monospace; !* めっちゃ特徴的な等幅フォント *!*/
        }
    </style>
</head>
<body>
@yield('content')

@stack('scripts')
</body>
</html>
