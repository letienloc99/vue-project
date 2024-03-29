<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\HistoryCallApi;
use App\Models\HistoryCallWebhook;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @OA\Info(
 * title="Sapo-Qlk Api Documentation",
 * version="1.0.0",
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponseSuccess($data = [], $message = 'success')
    {
        return response()->json([
            'code' => 0,
            'message' => $message,
            'result'    => $data
        ], 200, [
            'Content-type' => 'application/json; charset=utf-8',
            'Charset' => 'utf-8'
        ], JSON_UNESCAPED_UNICODE);
    }
    public function sendPaginate($paginate)
    {
        return $this->sendResponseSuccess(
            [
                'data' => $paginate->items(),
                'total' => $paginate->total(),
                'per_page' => $paginate->perPage(),
                'current_page' => $paginate->currentPage(),
                'last_page' => $paginate->lastPage(),
            ]
        );
    }

    /**
     * Send Respond Error to Client.
     *
     * @param object $data
     * @param string $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponseError(array $data = [], $message = 'error', $code = 404)
    {
        return response()->json([
            'code' => 0,
            'message' => $message,
            'result'    => $data
        ], $code);
    }

    protected function sendUnvalidated($errors)
    {
        $code = 422;
        return response()->json([
            'message' => 'The given data was invalid',
            'errors' => $errors
        ], $code);
    }





    public function log($message)
    {
        Log::debug($message);
    }
    public function logAsArray($message)
    {
        $logData = json_decode(json_encode($message), true);
        Log::debug($logData);
    }
    protected function respondWithToken($token, $guard = null)
    {
        // auth($guard)->user()->load('shop');
        return response()->json([
            'code' => 0,
            'message' => 'Login success!',
            'result' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth($guard)->user()
            ]
        ]);
    }

    /**
     * Send Respond Error to Client.
     *
     * @param int $type: 1-sapo, 2-ahamove
     * @param array $result
     * @param array $params
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Save history webhook.
     *
     * @param int $type: 1-sapo, 2-ahamove
     * @param array $data
     * @param array $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
}
