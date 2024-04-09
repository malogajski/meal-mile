<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'team_code',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($team) {
            $team->team_code = static::generateTeamCode();
        });
    }

    protected static function generateTeamCode($length = 8): string
    {
        return strtoupper(substr(md5(uniqid()), 0, $length));
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('approved');
    }
}
