<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Car.
 *
 * @OA\Schema(
 *     schema="Car",
 *     title="Car",
 *     description="Car model",
 *     @OA\Xml(name="Car"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="name", type="string", example="Nissan"),
 *     @OA\Property(property="user_id", type="integer", example="1"),
 *     @OA\Property(property="owner", ref="#/components/schemas/User"),
 *     @OA\Property(property="created_at", type="date-time", readOnly="true", example="2022-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="date-time", readOnly="true", example="2022-01-01 00:00:00"),
 * )
 */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
