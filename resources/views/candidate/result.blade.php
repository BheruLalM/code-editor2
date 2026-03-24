@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Test Result</h2>
    <p><b>Name:</b> {{ $attempt->candidate_name }}</p>
    <p><b>Score:</b> {{ $attempt->score }}</p>
    <p><b>Passed:</b> {{ $attempt->passed_cases }}/{{ $attempt->total_cases }}</p>
    <p><b>Status:</b> {{ $attempt->status }}</p>
</div>
@endsection
