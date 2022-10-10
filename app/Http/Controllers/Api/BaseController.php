<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\Response;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Carsharing Service API",
 * )
 * @OA\Schemes(format="http")
 */
class BaseController extends Controller
{
    use Response;
}
