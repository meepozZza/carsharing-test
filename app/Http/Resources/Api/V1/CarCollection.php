<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

/**
 * Car collection.
 *
 * @OA\Schema(
 *     schema="CarCollection",
 *     title="Car Collection",
 *     @OA\Xml(name="CarCollection"),
 *     @OA\Property(
 *         title="Car Collection",
 *         property="data",
 *         type="array",
 *         description="Currencies",
 *         @OA\Items(ref="#/components/schemas/Car")
 *     )
 * )
 */
class CarCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = CarResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return CarResource::collection($this->collection);
    }
}
