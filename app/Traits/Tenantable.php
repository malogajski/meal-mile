<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $team_id
 */
trait Tenantable
{
    protected int $team_id;

    public static function bootTenantable()
    {
        if (app()->runningInConsole()) {
            return;
        }

        // Automatically assigns the team_id to the currently authenticated user when creating a model
        static::creating(function (Model $model) {
            if (!auth()->check()) {
                return;
            }
            $model->team_id = auth()->user()->team_id;
        });

        // Adds a global scope that filters data based on the team_id of the currently authenticated user
        static::addGlobalScope('team_filter', function (Builder $query) {
            if (!auth()->check()) {
                return;
            }

            $teamId = auth()->user()->team_id;

            if ($teamId) {
                // @phpstan-ignore-next-line
                $query->where((new static())->getTable() . '.team_id', $teamId);
            }
        });
    }
}
