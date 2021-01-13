<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'firstname',
        'secondname',
        'email',
        'phone',
        'education',
        'ip',
        'agent',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Education types list
     *
     * @return array
     */
    public static function educationsList(): array
    {
        return [
            self::EDUCATION_BACHELOR => 'Bachelor',
            self::EDUCATION_MASTER => 'Master',
            self::EDUCATION_PHD => 'PhD',
        ];
    }
}
