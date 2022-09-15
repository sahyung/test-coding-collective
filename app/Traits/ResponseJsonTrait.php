<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseJsonTrait
{
    /**
     * Message response success
     * types : get_data, store_data, update_data
     *      delete_data, login, logout
     *
     * @return mixed
     */
    protected function responseSuccess($type, $options = [])
    {
        switch ($type) {
            case 'store_data':
                $code = Response::HTTP_CREATED;
                break;
            default:
                $code = Response::HTTP_OK;
                break;
        }

        return response()->json([
            'message' => isset($options['message']) ? $options['message'] : __('response.success_' . $type),
            'data' => isset($options['data']) ? $options['data'] : null,
            'success' => true,
        ], $code);
    }

    /**
     * Api error response
     *
     * @param  string|array $message
     * @param int $code
     *
     * @return Illuminate\Http\Response
     */
    protected function responseError($type, $options = [])
    {
        switch ($type) {
            case 'validation':
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            case 'not_found':
                $code = Response::HTTP_NOT_FOUND;
                break;
            case 'forbidden':
                $code = Response::HTTP_FORBIDDEN;
                break;
            case 'bad_request':
                $code = Response::HTTP_BAD_REQUEST;
                break;
            case 'unauthenticated':
                $code = Response::HTTP_UNAUTHORIZED;
                break;
                $code = Response::HTTP_BAD_REQUEST;
                break;
            case 'conflict':
                $code = Response::HTTP_CONFLICT;
                break;
            default:
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }

        return response()->json([
            'message' => isset($options['message']) ? $options['message'] : __('response.error_' . $type),
            'errors' => isset($options['data']) ? $options['data'] : [],
            'code' => $code,
            'success' => false,
        ], $code);
    }
}
