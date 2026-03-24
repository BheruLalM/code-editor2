<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $fillable = [
        'username',
        'email',
        'hashed_password',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function testSessions(): HasMany
    {
        return $this->hasMany(TestSession::class, 'created_by');
    }
}
