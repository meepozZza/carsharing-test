<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CarsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A browse cars.
     *
     * @return void
     */
    public function test_browse_cars(): void
    {
        $this->get('/api/v1/cars')
            ->assertStatus(200);
    }

    /**
     * Test store car.
     *
     * @return void
     */
    public function test_store_random_car_data(): void
    {
        $this->post('/api/v1/cars', Car::factory()->makeOne()->toArray())
            ->assertStatus(200);
    }

    /**
     * Test browse any car.
     *
     * @return void
     */
    public function test_browse_any_car(): void
    {
        $car = Car::inRandomOrder()->first();

        $this->get("/api/v1/cars/{$car?->id}")
            ->assertStatus(200);
    }

    /**
     * Test update car.
     *
     * @return void
     */
    public function test_update_random_car_data_on_any_car(): void
    {
        $car = Car::inRandomOrder()->first();

        $this->patch("/api/v1/cars/{$car?->id}", Car::factory()->makeOne()->toArray())
            ->assertStatus(200);
    }

    /**
     * Test delete random car.
     *
     * @return void
     */
    public function test_delete_random_car(): void
    {
        $car = Car::inRandomOrder()->first();

        $this->delete("/api/v1/cars/{$car?->id}")
            ->assertStatus(200);
    }
}
