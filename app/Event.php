<?php

namespace App;

use App\Scopes\ImageScope;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Add global scope
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ImageScope);
    }

    /**
     * Relation User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation Order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
