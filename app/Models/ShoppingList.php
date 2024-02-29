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
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ShoppingListItem::class);
    }
}
