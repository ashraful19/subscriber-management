<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'name', 'last_name', 'state'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => trim($attributes['name'].' '.(isset($attributes['last_name']) ? $attributes['last_name'] : '')),
        );
    }
    /**
     * The fields that belong to the Subscriber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class, 'subscriber_fields', 'subscriber_id', 'field_id')->withPivot(['value'])->withTimestamps();
    }
}
