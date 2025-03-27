@props([
    'isAdmin' => false // デフォルトはfalse（ユーザー用）
])

<div class="nav">
{{--    <div>--}}
{{--        <p>isAdmin: {{ $isAdmin ? 'true' : 'false' }}</p>--}}
{{--        <p>isAdmin: {{ gettype($isAdmin) }} / {{ var_export($isAdmin, true) }}</p>--}}
{{--    </div>--}}
    {{-- 管理者専用ボタン --}}
    @if ($isAdmin)
        <form method="POST" action="{{ route('admin.login.destroy') }}">
            @method('DELETE')
            @csrf
            <button type="submit" class="button back">ログアウト</button>
        </form>
        <div class="new_button">
            <div class="edit_button">
                <a href="{{ route('tasks.store') }}" class="button register">タスク新規登録</a>
            </div>
        </div>
        <div class="delete_button">
            <div class="edit_button">
                <a href="{{ route('tasks.deletedList') }}" class="button delete">削除済一覧</a>
            </div>
        </div>
    @else
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
    @endif

    {{-- 共通：ハンバーガーメニュー --}}
    <div class="humburger_btn">
        <button class="menu_button">☰</button>
    </div>

    <div class="comment">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
