<?php

declare(strict_types=1);


namespace App\AI\Providers;

use App\AI\Prompts\EnglishAssistantPrompt;
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
     * @param string $message
     * @return string
     * @throws ConnectionException
     */
    public function get(int $userId, int $chatId, string $message): string
    {
        $response = Http::post('llm/chat', [
            'prompt'  => $this->prompt(),
            'user_id' => $userId,
            'chat_id' => $chatId,
            'message' => $message,
        ]);

        if ($response->status() !== 200) {
            throw new RuntimeException('Вышла ошибка при выполнении запроса. Вернул: ' . $response->body());
        }

        return $response->json()['reply'];
    }

    /**
     * @return string
     */
    protected function prompt(): string
    {
        return EnglishAssistantPrompt::prompt();
    }
}
