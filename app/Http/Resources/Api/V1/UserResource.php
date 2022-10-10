<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User.
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Xml(name="User"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="name", type="string", example="Ivan"),
 *     @OA\Property(property="car", ref="#/components/schemas/Car"),
 *     @OA\Property(property="created_at", type="date-time", readOnly="true", example="2022-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="date-time", readOnly="true", example="2022-01-01 00:00:00"),
 * )
 */
class UserResource extends JsonResource
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
            'car' => new CarResource($this->whenLoaded('car')),
            'updated_at' => $this->resource->updated_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
