<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * This is the model class for table "cars"
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $owner
 */
class Car extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'cars';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'updated_at' => 'string',
        'created_at' => 'string',
    ];

    /**
     * @inheritdoc
     */
    public $timestamps = true;

    /**
     * Set null in user id.
     *
     * @return Car
     */
    public function setNullOnUserId(): Car
    {
        $this->user_id = null;
        $this->save();

        return $this;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsAvailable(Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }

    /**
     * Car owner relation.
     *
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
