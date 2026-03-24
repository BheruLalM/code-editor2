@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h2>Admin Dashboard</h2>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </div>
    <a class="btn" href="{{ route('admin.sessions.create') }}">Create Session</a>
</div>

<div class="card">
    <h3>Test Sessions</h3>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Token</th>
            <th>Attempts</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($sessions as $session)
            <tr>
                <td><a href="{{ route('admin.sessions.show', $session) }}">{{ $session->title }}</a></td>
                <td>{{ $session->session_token }}</td>
                <td>{{ $session->attempts_count }}</td>
                <td>{{ $session->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No sessions yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
