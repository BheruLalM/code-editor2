<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Problem extends Model
{
    protected $fillable = [
        'title',
        'difficulty',
        'description',
        'starter_code',
        'visible_test_cases',
        'hidden_test_cases',
        'time_limit_seconds',
        'tags',
    ];

    protected $casts = [
        'starter_code' => 'array',
        'visible_test_cases' => 'array',
        'hidden_test_cases' => 'array',
        'tags' => 'array',
    ];

    public function attempts(): HasMany
    {
        return $this->hasMany(CandidateAttempt::class, 'assigned_problem_id');
    }
}
