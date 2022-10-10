<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Car\CarDestroyRequest;
use App\Http\Requests\Api\V1\Car\CarIndexRequest;
use App\Http\Requests\Api\V1\Car\CarShowRequest;
use App\Http\Requests\Api\V1\Car\CarStoreRequest;
use App\Http\Requests\Api\V1\Car\CarUpdateRequest;
use App\Http\Resources\Api\V1\CarCollection;
use App\Http\Resources\Api\V1\CarResource;
use App\Http\Resources\Api\V1\DestroyResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarController extends BaseController
{
    /**
     * @OA\Get(
     *      path="/api/v1/cars",
     *      operationId="cars.index",
     *      tags={"V1, Cars"},
     *      summary="Get car`s list",
     *      description="Returns car`s data.",
     *      @OA\Parameter(
     *          description="With relations",
     *          in="query",
     *          name="with",
     *          required=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="string"),
     *              example={"owner"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CarCollection")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display a listing of the resource.
     *
     * @param CarIndexRequest $request
     * @return JsonResponse
     */
    public function index(CarIndexRequest $request): JsonResponse
    {
        return $this->sendResponse(
            new CarCollection(
                Car::with($request->get('with', []))->get(),
            ),
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/cars",
     *      operationId="cars.store",
     *      tags={"V1, Cars"},
     *      summary="Store car",
     *      description="Store car and returns car`s data.",
     *      @OA\Parameter(
     *          description="Name",
     *          in="query",
     *          name="name",
     *          required=true,
     *          example="Nissan"
     *      ),
     *      @OA\Parameter(
     *          description="Car owner id",
     *          in="query",
     *          name="user_id",
     *          required=false,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Car")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param CarStoreRequest $request
     * @return JsonResponse
     */
    public function store(CarStoreRequest $request): JsonResponse
    {
        return $this->sendResponse(
            new CarResource(Car::create($request->validated())),
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/cars/{id}",
     *      operationId="cars.show",
     *      tags={"V1, Cars"},
     *      summary="Get car",
     *      description="Returns car data.",
     *      @OA\Parameter(
     *          description="Id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1"
     *      ),
     *      @OA\Parameter(
     *          description="With relations",
     *          in="query",
     *          name="with",
     *          required=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="string"),
     *              example={"owner"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Car")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param CarShowRequest $request
     * @param Car $car
     * @return JsonResponse
     */
    public function show(CarShowRequest $request, Car $car): JsonResponse
    {
        return $this->sendResponse(
            new CarResource($car->load($request->get('with', []))),
        );
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/cars/{id}",
     *      operationId="cars.update",
     *      tags={"V1, Cars"},
     *      summary="Update car",
     *      description="Update car and returns car`s data.",
     *      @OA\Parameter(
     *          description="Id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1"
     *      ),
     *      @OA\Parameter(
     *          description="Name",
     *          in="query",
     *          name="name",
     *          required=false,
     *          example="Nissan"
     *      ),
     *      @OA\Parameter(
     *          description="Car owner id",
     *          in="query",
     *          name="user_id",
     *          required=false,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Car")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param CarUpdateRequest $request
     * @param Car $car
     * @return JsonResponse
     */
    public function update(CarUpdateRequest $request, Car $car): JsonResponse
    {
        $car->update($request->validated());

        return $this->sendResponse(
            new CarResource($car),
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/cars/{id}",
     *      operationId="cars.delete",
     *      tags={"V1, Cars"},
     *      summary="Destroy car",
     *      description="Returns delete status.",
     *      @OA\Parameter(
     *          description="Id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param CarDestroyRequest $request
     * @param Car $car
     * @return JsonResponse
     */
    public function destroy(CarDestroyRequest $request, Car $car): JsonResponse
    {
        return $this->sendResponse(
            new DestroyResource($car->delete()),
        );
    }
}
