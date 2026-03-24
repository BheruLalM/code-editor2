@extends('layouts.app')

@section('content')
<div class="card">
    <h2>{{ $session->title }}</h2>
    <p><b>Session Token:</b> {{ $session->session_token }}</p>
    <p><b>Candidate Link:</b> {{ url('/test/'.$session->session_token) }}</p>
</div>

<div class="card">
    <h3>Candidates</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($session->attempts as $attempt)
            <tr>
                <td><a href="{{ route('admin.candidates.show', $attempt) }}">{{ $attempt->candidate_name }}</a></td>
                <td>{{ $attempt->candidate_email }}</td>
                <td>{{ $attempt->status }}</td>
                <td>{{ $attempt->score }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No candidates yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
