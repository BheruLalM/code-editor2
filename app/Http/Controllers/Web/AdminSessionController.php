<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CandidateAttempt;
use App\Models\TestSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminSessionController extends Controller
{
    public function dashboard()
    {
        $sessions = TestSession::withCount('attempts')->latest()->get();

        return view('admin.dashboard', compact('sessions'));
    }

    public function create()
    {
        return view('admin.sessions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty_filter' => ['required', 'in:easy,medium,hard,any'],
            'time_limit_minutes' => ['required', 'integer', 'min:5', 'max:300'],
            'max_attempts' => ['required', 'integer', 'min:1', 'max:5'],
            'expires_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $session = TestSession::create([
            ...$data,
            'session_token' => Str::lower(Str::random(12)),
            'is_active' => (bool) ($data['is_active'] ?? true),
            'created_by' => (int) session('admin_id'),
        ]);

        return redirect()->route('admin.sessions.show', $session)->with('ok', 'Session created');
    }

    public function show(TestSession $session)
    {
        $session->load(['attempts.problem']);

        return view('admin.sessions.show', compact('session'));
    }

    public function candidate(CandidateAttempt $attempt)
    {
        $attempt->load(['session', 'problem']);

        return view('admin.candidates.show', compact('attempt'));
    }
}
