<?php

declare(strict_types=1);


namespace app\AI\Providers;

use app\AI\SystemPrompt;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class ChatProvider
{
    /**
     * Задать вопрос LLM.
     *
     * @param int $userId
     * @param int $chatId
     * @param string $question
     * @return string
     * @throws ConnectionException
     */
    public function get(int $userId, int $chatId, string $question): string
    {
        $response = Http::post('llm/chat', [
            'prompt'  => SystemPrompt::prompt(),
            'user_id' => $userId,
            'chat_id' => $chatId,
            'message' => $question,
        ]);

        if ($response->status() !== 200) {
            throw new RuntimeException('Вышла ошибка при выполнении запроса. Вернул: ' . $response->body());
        }

        return $response->json()['message'];
    }
}
