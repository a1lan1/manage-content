<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const EDUCATION_BACHELOR = 1;
    const EDUCATION_MASTER = 2;
    const EDUCATION_PHD = 3;

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'secondname', 'email', 'phone', 'education', 'ip', 'agent'
    ];

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
     * Relation Event model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Education list
     *
     * @return array
     */
    public static function educationsList()
    {
        return [
            self::EDUCATION_BACHELOR => 'Bachelor',
            self::EDUCATION_MASTER => 'Master',
            self::EDUCATION_PHD => 'PhD',
        ];
    }
}
