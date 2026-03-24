<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CandidateAttempt;
use App\Models\Problem;
use App\Models\TestSession;
use App\Services\CodeRunnerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CandidateTestController extends Controller
{
    public function testLanding(string $token)
    {
        $session = TestSession::where('session_token', $token)->first();

        if (! $session || ! $session->is_active || ($session->expires_at && $session->expires_at->isPast())) {
            return view('candidate.invalid-token');
        }

        return view('candidate.register', compact('session'));
    }

    public function register(Request $request, string $token)
    {
        $session = TestSession::where('session_token', $token)->firstOrFail();
        $data = $request->validate([
            'candidate_name' => ['required', 'string', 'max:255'],
            'candidate_email' => ['required', 'email', 'max:255'],
        ]);

        $attempt = CandidateAttempt::where('session_id', $session->id)
            ->where('candidate_email', $data['candidate_email'])
            ->first();

        if ($attempt && $attempt->status === 'submitted') {
            return redirect()->route('candidate.result', $attempt->candidate_token);
        }

        if (! $attempt) {
            $problem = $this->pickProblem($session->difficulty_filter);
            if (! $problem) {
                return back()->withErrors(['candidate_email' => 'No problem available for this session.']);
            }

            $attempt = CandidateAttempt::create([
                'session_id' => $session->id,
                'candidate_token' => Str::lower(Str::random(24)),
                'candidate_name' => $data['candidate_name'],
                'candidate_email' => $data['candidate_email'],
                'assigned_problem_id' => $problem->id,
                'status' => 'registered',
            ]);
        }

        return redirect()->route('candidate.solve', $attempt->candidate_token);
    }

    public function solve(string $token)
    {
        $attempt = CandidateAttempt::where('candidate_token', $token)->with(['problem', 'session'])->firstOrFail();

        if ($attempt->status === 'submitted') {
            return redirect()->route('candidate.result', $attempt->candidate_token);
        }

        if (! $attempt->started_at) {
            $attempt->started_at = now();
            $attempt->status = 'started';
            $attempt->save();
        }

        if ($this->isTimeOver($attempt)) {
            $attempt->status = 'timed_out';
            $attempt->save();
        }

        return view('candidate.solve', compact('attempt'));
    }

    public function run(Request $request, string $token, CodeRunnerService $runner)
    {
        $attempt = CandidateAttempt::where('candidate_token', $token)->with('problem')->firstOrFail();
        $data = $request->validate([
            'language' => ['required', 'string'],
            'code' => ['required', 'string'],
        ]);

        $evaluation = $runner->evaluate($data['language'], $data['code'], $attempt->problem->visible_test_cases ?? []);

        return back()->withInput()->with('run_results', $evaluation['results']);
    }

    public function submit(Request $request, string $token, CodeRunnerService $runner)
    {
        $attempt = CandidateAttempt::where('candidate_token', $token)->with(['problem', 'session'])->firstOrFail();

        if ($attempt->status === 'submitted') {
            return redirect()->route('candidate.result', $attempt->candidate_token);
        }

        $data = $request->validate([
            'language' => ['required', 'string'],
            'code' => ['required', 'string'],
        ]);

        $allCases = array_merge(
            $attempt->problem->visible_test_cases ?? [],
            $attempt->problem->hidden_test_cases ?? []
        );
        $evaluation = $runner->evaluate($data['language'], $data['code'], $allCases);

        $total = count($evaluation['results']);
        $passed = collect($evaluation['results'])->where('passed', true)->count();
        $score = $total > 0 ? (int) round(($passed / $total) * 100) : 0;

        $startedAt = $attempt->started_at ?? Carbon::now();
        $attempt->update([
            'language' => $data['language'],
            'submitted_code' => $data['code'],
            'status' => 'submitted',
            'submitted_at' => now(),
            'score' => $score,
            'passed_cases' => $passed,
            'total_cases' => $total,
            'test_results' => $evaluation['results'],
            'time_taken_seconds' => $startedAt->diffInSeconds(now()),
        ]);

        return redirect()->route('candidate.result', $attempt->candidate_token);
    }

    public function result(string $token)
    {
        $attempt = CandidateAttempt::where('candidate_token', $token)->with('problem')->firstOrFail();

        return view('candidate.result', compact('attempt'));
    }

    private function pickProblem(string $difficulty): ?Problem
    {
        if ($difficulty === 'any') {
            return Problem::inRandomOrder()->first();
        }

        return Problem::where('difficulty', $difficulty)->inRandomOrder()->first();
    }

    private function isTimeOver(CandidateAttempt $attempt): bool
    {
        if (! $attempt->started_at) {
            return false;
        }

        $end = $attempt->started_at->copy()->addMinutes($attempt->session->time_limit_minutes);

        return now()->greaterThan($end);
    }
}
