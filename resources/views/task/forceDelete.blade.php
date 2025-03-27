@extends('layouts.app')

@section('title', 'タスク管理一覧')

@section('vite')
    @vite(['resources/js/delete_show.js'])
@endsection

@section('header')
    <!--        レイアウト調整領域（ヘッダー）-->
    <div class="header_inner">
        <!--            編集画面遷移用ボタン-->
        <h2>タスクの完全削除</h2>
    </div>
@endsection
<!--メイン-->
@section('content')
    <div class="main">
        <!--        レイアウト調整領域（メイン）-->
        <div class="main_inner">
            <div class="button_area">
                <div class="nav">
                    <a href="{{ route('tasks.deletedList') }}" class="button back">削除一覧へ戻る</a>
                </div>
            </div>
            <!--            タスク一覧表示領域-->
            <div class="search_list">
                <div class="container">
                    <p>以下のタスクを完全削除しますか？</p>
                    <div class="delete_task">
                        <dl>
                            <dt>タスク名</dt>
                            <dd>{{ $task->task_name }}</dd>
                            <dt>開始日</dt>
                            <dd>{{ $task->ymd_to }}</dd>
                            <dt>終了日</dt>
                            <dd>{{ $task->ymd_from }}</dd>
                            <dt>内容</dt>
                            <dd>{{ $task->task_content }}</dd>
                            <dt>ステータス</dt>
                            <dd>
                                @switch($task->status)
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
                            </dd>

                        </dl>

                    </div>

                    <!-- 復元ボタン -->
                    <form method="POST" action="{{ route('tasks.forceDelete', $task->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">完全削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

