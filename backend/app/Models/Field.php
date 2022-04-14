<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'tag', 'type'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->tag = Str::of($model->title)->trim()->slug('_');
        });

        static::updating(function ($model) {
            $model->tag = Str::of($model->title)->trim()->slug('_');
        });
    }

    public function tag(): Attribute
    {
        return new Attribute(
            get: fn ($value) => '${'.$value.'}'
        );
    }

    /**
     * The subscribers that belong to the Fields
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_fields', 'field_id', 'subscriber_id')->withPivot(['value'])->withTimestamps();
    }
}
