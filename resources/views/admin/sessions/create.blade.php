@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <h2>Create Test Session</h2>
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.sessions.store') }}">
        @csrf
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        <label>Description</label>
        <textarea name="description" rows="4">{{ old('description') }}</textarea>
        <label>Difficulty Filter</label>
        <select name="difficulty_filter" required>
            @foreach (['easy','medium','hard','any'] as $level)
                <option value="{{ $level }}">{{ ucfirst($level) }}</option>
            @endforeach
        </select>
        <label>Time Limit (minutes)</label>
        <input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', 60) }}" required>
        <label>Max Attempts</label>
        <input type="number" name="max_attempts" value="{{ old('max_attempts', 1) }}" required>
        <label>Expires At (optional)</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}">
        <button class="btn" type="submit">Create Session</button>
    </form>
</div>
@endsection
