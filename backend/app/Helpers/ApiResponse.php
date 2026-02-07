<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse; 

/**
 * Единообразные JSON-ответы API.
 */
final class ApiResponse
{
    /**
     * Успешный ответ с данными (в т.ч. для пагинации).
     *
     * @param mixed $data Данные для ответа (массив, ресурс, пагинатор)
     * @param int   $status HTTP-код ответа
     * @return JsonResponse
     */
    public static function success(mixed $data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Ответ «не найдено» (404).
     *
     * @param string $message Текст сообщения
     * @return JsonResponse
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
        ], 404, [], JSON_UNESCAPED_UNICODE);
    }
}