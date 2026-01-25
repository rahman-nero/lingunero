<?php

namespace App\Repository;

use App\Models\LLMChatMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Builder model()
 */
final class LLMChatMessagesRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return LLMChatMessage::class;
    }

    /**
     * Получение всех сообщений чата.
     *
     * @param int $userId
     * @param int $chatId
     * @return Collection<LLMChatMessage>
     */
    public function all(int $userId, int $chatId): Collection
    {
        return $this->model()
            ->whereRelation('chatRoom', 'user_id', '=', $userId)
            ->where('chat_room_id', '=', $chatId)
            ->orderBy('created_at')
            ->get();
    }
}
