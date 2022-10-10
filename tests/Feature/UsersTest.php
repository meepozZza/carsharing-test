<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A browse users.
     *
     * @return void
     */
    public function test_browse_users(): void
    {
        $this->get('/api/v1/users')
            ->assertStatus(200);
    }

    /**
     * Test store user.
     *
     * @return void
     */
    public function test_store_random_user_data(): void
    {
        $data = User::factory()->makeOne()->toArray();

        $this->post('/api/v1/users', $data)
            ->assertStatus(200);
    }

    /**
     * Test store user data with any available car.
     *
     * @return void
     */
    public function test_store_user_data_with_any_available_car(): void
    {
        $data = User::factory()->makeOne()->toArray();
        $data['car_id'] = Car::isAvailable()->first()?->id;

        $this->post('/api/v1/users', $data)
            ->assertStatus(200);
    }

    /**
     * Test browse any user.
     *
     * @return void
     */
    public function test_browse_any_user(): void
    {
        $user = User::inRandomOrder()->first();

        $this->get("/api/v1/users/{$user?->id}")
            ->assertStatus(200);
    }

    /**
     * Test update user.
     *
     * @return void
     */
    public function test_update_random_user_data_on_any_user(): void
    {
        $user = User::inRandomOrder()->first();

        $this->patch("/api/v1/users/{$user?->id}", User::factory()->makeOne()->toArray())
            ->assertStatus(200);
    }

    /**
     * Test update user with any available car.
     *
     * @return void
     */
    public function test_update_random_user_data_with_any_available_car_on_any_user(): void
    {
        $user = User::inRandomOrder()->first();
        $data = User::factory()->makeOne()->toArray();
        $data['car_id'] = Car::isAvailable()->first()?->id;

        $this->patch("/api/v1/users/{$user?->id}", $data)
            ->assertStatus(200);
    }

    /**
     * Test update user with any available car.
     *
     * @return void
     */
    public function test_update_random_user_data_with_nullable_car_id_on_user_with_car(): void
    {
        $user = User::inRandomOrder()->whereHas('car')->first();
        $data = User::factory()->makeOne()->toArray();
        $data['car_id'] = null;

        $this->patch("/api/v1/users/{$user?->id}", $data)
            ->assertStatus(200);
    }

    /**
     * Test delete random user.
     *
     * @return void
     */
    public function test_delete_random_user(): void
    {
        $user = User::inRandomOrder()->first();

        $this->delete("/api/v1/users/{$user?->id}")
            ->assertStatus(200);
    }
}
