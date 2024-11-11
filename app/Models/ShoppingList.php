<?php

namespace App\Models;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory, Tenantable;

    protected $fillable = [
        'team_id',
        'user_id',
        'name',
        'description',
        'start',
        'end',
        'total_amount',
        'type',
        'active',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShoppingListItem::class);
    }
}
