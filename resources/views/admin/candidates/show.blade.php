@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Candidate Result</h2>
    <p><b>Name:</b> {{ $attempt->candidate_name }}</p>
    <p><b>Email:</b> {{ $attempt->candidate_email }}</p>
    <p><b>Status:</b> {{ $attempt->status }}</p>
    <p><b>Score:</b> {{ $attempt->score }} ({{ $attempt->passed_cases }}/{{ $attempt->total_cases }})</p>
    <p><b>Language:</b> {{ $attempt->language }}</p>
    <p><b>Submitted Code:</b></p>
    <pre style="white-space: pre-wrap">{{ $attempt->submitted_code }}</pre>
</div>

<div class="card">
    <h3>Test Case Results</h3>
    <table>
        <thead>
        <tr><th>Input</th><th>Expected</th><th>Output</th><th>Passed</th></tr>
        </thead>
        <tbody>
        @forelse (($attempt->test_results ?? []) as $row)
            <tr>
                <td>{{ $row['input'] ?? '' }}</td>
                <td>{{ $row['expected'] ?? '' }}</td>
                <td>{{ $row['output'] ?? '' }}</td>
                <td>{{ !empty($row['passed']) ? 'Yes' : 'No' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No results.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
