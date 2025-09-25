<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Meal extends Model
{
    protected $fillable = ['date', 'type', 'items'];

    protected $casts = [
        'date' => 'date',
        'items' => 'array',
    ];

    /**
     * Accessor: format date nicely when retrieved
     */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('l, d M Y');
    }

    /**
     * Scope: get all meals for a given date
     */
    public function scopeForDate(Builder $query, $date): Builder
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope: search meals by item (e.g. "eggs")
     */
    public function scopeWithItem(Builder $query, string $item): Builder
    {
        return $query->whereJsonContains('items', $item);
    }
}
