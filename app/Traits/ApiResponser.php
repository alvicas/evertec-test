<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * successResponse
     *
     * @param $data
     * @param integer $code
     * @return JsonResponse
     */
    protected function successResponse( $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'status'   => 'ok',
            'code'     => $code,
            'messages' => [],
            'result'   => $data,
        ], $code);
    }

    /**
     * Undocumented function
     *
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function errorResponse( string $message, int $code ): JsonResponse
    {
        return response()->json(
        [
            'status'   => 'error',
            'code'     => $code,
            'messages' => $message,
            'result'   => [],
        ], $code);
    }
}
