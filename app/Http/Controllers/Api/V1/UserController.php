<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\User\UserDestroyRequest;
use App\Http\Requests\Api\V1\User\UserIndexRequest;
use App\Http\Requests\Api\V1\User\UserShowRequest;
use App\Http\Requests\Api\V1\User\UserStoreRequest;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;
use App\Http\Resources\Api\V1\UserCollection;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Resources\Api\V1\DestroyResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    /**
     * @OA\Get(
     *      path="/api/v1/users",
     *      operationId="users.index",
     *      tags={"V1, Users"},
     *      summary="Get user`s list",
     *      description="Returns user`s data.",
     *      @OA\Parameter(
     *          description="With relations",
     *          in="query",
     *          name="with",
     *          required=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="string"),
     *              example={"car"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UserCollection")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @return JsonResponse
     */
    public function index(UserIndexRequest $request): JsonResponse
    {
        return $this->sendResponse(
            new UserCollection(
                User::with($request->get('with', []))->get(),
            ),
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/users",
     *      operationId="users.store",
     *      tags={"V1, Users"},
     *      summary="Store user",
     *      description="Store user and returns user`s data.",
     *      @OA\Parameter(
     *          description="Name",
     *          in="query",
     *          name="name",
     *          required=true,
     *          example="Ivan"
     *      ),
     *      @OA\Parameter(
     *          description="Car id",
     *          in="query",
     *          name="car_id",
     *          required=false,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::create($request->validated());

        $request->whenHas(
            'car_id',
            fn ($carId) => $user->saveUserCarByCarId($carId),
        );

        return $this->sendResponse(
            new UserResource($user),
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/users/{id}",
     *      operationId="users.show",
     *      tags={"V1, Users"},
     *      summary="Get user",
     *      description="Returns user data.",
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
     *              example={"car"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param UserShowRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function show(UserShowRequest $request, User $user): JsonResponse
    {
        return $this->sendResponse(
            new UserResource($user->load($request->get('with', []))),
        );
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/users/{id}",
     *      operationId="users.update",
     *      tags={"V1, Users"},
     *      summary="Update user",
     *      description="Update user and returns user`s data.",
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
     *          example="Ivan"
     *      ),
     *      @OA\Parameter(
     *          description="Car id",
     *          in="query",
     *          name="car_id",
     *          required=false,
     *          example="1"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        $request->whenHas(
            'car_id',
            fn ($carId) => $user->saveUserCarByCarId($carId),
        );

        return $this->sendResponse(
            new UserResource($user),
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/users/{id}",
     *      operationId="users.delete",
     *      tags={"V1, Users"},
     *      summary="Destroy user",
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
     * @param UserDestroyRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(UserDestroyRequest $request, User $user): JsonResponse
    {
        return $this->sendResponse(
            new DestroyResource($user->delete()),
        );
    }
}
