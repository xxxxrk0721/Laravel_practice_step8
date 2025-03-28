@foreach (['task_name', 'task_content', 'ymd_to', 'ymd_from'] as $field)
    @error($field)
    <div class="error-message" style="color: red;">{{ $message }}</div>
    @enderror
@endforeach
