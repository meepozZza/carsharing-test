<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

/**
 * User collection.
 *
 * @OA\Schema(
 *     schema="UserCollection",
 *     title="User Collection",
 *     @OA\Xml(name="UserCollection"),
 *     @OA\Property(
 *         title="User Collection",
 *         property="data",
 *         type="array",
 *         description="Currencies",
 *         @OA\Items(ref="#/components/schemas/User")
 *     )
 * )
 */
class UserCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = UserResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return UserResource::collection($this->collection);
    }
}
