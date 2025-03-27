<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? '管理' }}</title>
    @vite(['resources/js/app.js'])

    <style>
        {{ $style ?? '' }}
    </style>
</head>
