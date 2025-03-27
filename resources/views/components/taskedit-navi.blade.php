@props([
    'isAdmin' => false, // デフォルトはfalse（ユーザー用）
    'task',
])

<div class="nav">
    {{-- 管理者専用ボタン --}}
    @if ($isAdmin)
        <div class="allnemu_button">
            <a href="{{ route('tasks.index') }}" class="button back">タスク一覧へ戻る</a>
        </div>
        <div class="delete_area">
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('このタスクを削除しますか？')" class="button delete">削除</button>
            </form>
        </div>
    @else
    <!--            一覧画面遷移用ボタン-->
        <div class="allnemu_button">
            <a href="{{ route('user.dashboard') }}" class="button back">タスク一覧へ戻る</a>
        </div>
        <div class="delete_area">
            <form action="{{ route('user.dashboard.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('このタスクを削除しますか？')" class="button delete">削除</button>
            </form>
        </div>
    @endif
</div>
