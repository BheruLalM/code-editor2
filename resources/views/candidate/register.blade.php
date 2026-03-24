@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px;">
    <h2>{{ $session->title }}</h2>
    <p>{{ $session->description }}</p>
    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('candidate.register', $session->session_token) }}">
        @csrf
        <label>Name</label>
        <input type="text" name="candidate_name" value="{{ old('candidate_name') }}" required>
        <label>Email</label>
        <input type="email" name="candidate_email" value="{{ old('candidate_email') }}" required>
        <button class="btn" type="submit">Start Test</button>
    </form>
</div>
@endsection
