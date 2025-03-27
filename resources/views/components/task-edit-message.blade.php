<div class="success">
    @if (session('success'))
        <p style="color: green;" class="success_message">{{ session('success') }}</p>
    @endif
    @if (session('info'))
        <p style="color: green;" class="success_message">{{ session('info') }}</p>
    @endif
</div>
@foreach (['task_name', 'task_content', 'ymd_to', 'ymd_from'] as $field)
    @error($field)
    <div class="error-message" style="color: red;">{{ $message }}</div>
    @enderror
@endforeach
