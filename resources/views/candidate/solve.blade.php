@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Solve: {{ $attempt->problem->title }}</h2>
    <p><b>Candidate:</b> {{ $attempt->candidate_name }} ({{ $attempt->candidate_email }})</p>
    <p><b>Status:</b> {{ $attempt->status }}</p>
    <p><b>Difficulty:</b> {{ $attempt->problem->difficulty }}</p>
    <p>{{ $attempt->problem->description }}</p>
</div>

<div class="card">
    @php
        $starter = $attempt->problem->starter_code['php'] ?? "<?php\n\n";
        $codeVal = old('code', $starter);
    @endphp
    <form method="POST" action="{{ route('candidate.run', $attempt->candidate_token) }}">
        @csrf
        <label>Language</label>
        <select name="language">
            <option value="php">php</option>
            <option value="python">python</option>
            <option value="javascript">javascript</option>
        </select>
        <label>Code</label>
        <textarea name="code" rows="14" required>{{ $codeVal }}</textarea>
        <button class="btn" type="submit">Run Visible Tests</button>
    </form>
</div>

@if (session('run_results'))
<div class="card">
    <h3>Run Results (Visible Tests)</h3>
    <table>
        <thead>
        <tr><th>Input</th><th>Expected</th><th>Output</th><th>Passed</th></tr>
        </thead>
        <tbody>
        @foreach (session('run_results') as $row)
            <tr>
                <td>{{ $row['input'] ?? '' }}</td>
                <td>{{ $row['expected'] ?? '' }}</td>
                <td>{{ $row['output'] ?? '' }}</td>
                <td>{{ !empty($row['passed']) ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="card">
    <form method="POST" action="{{ route('candidate.submit', $attempt->candidate_token) }}">
        @csrf
        <label>Language for Final Submit</label>
        <select name="language">
            <option value="php">php</option>
            <option value="python">python</option>
            <option value="javascript">javascript</option>
        </select>
        <label>Final Code</label>
        <textarea name="code" rows="12" required>{{ $codeVal }}</textarea>
        <button class="btn btn-danger" type="submit">Final Submit (One Time)</button>
    </form>
</div>
@endsection
