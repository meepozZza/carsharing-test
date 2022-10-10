<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * This is the model class for table "users"
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Car $car
 */
class User extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $table = 'users';

    /**
     * @inheritdoc
     */
    protected $fillable = [
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
     * Save car.
     *
     * @param int|null $carId
     * @return User
     */
    public function saveUserCarByCarId(?int $carId): User
    {
        switch (true) {
            case is_null($carId): {
                $this->car()->first()?->setNullOnUserId();
                break;
            }
            default: {
                if ($car = Car::isAvailable()->find($carId)) {
                    $this->car()->save($car);
                }
            }
        }

        return $this;
    }

    /**
     * Car relation.
     *
     * @return HasOne
     */
    public function car(): HasOne
    {
        return $this->hasOne(Car::class, 'user_id', 'id');
    }
}
