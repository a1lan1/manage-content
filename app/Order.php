<?php

namespace App;

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
     * Save user ip & user agent
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->ip = request()->getClientIp();
            $model->agent = request()->header('user_agent');
        });
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
