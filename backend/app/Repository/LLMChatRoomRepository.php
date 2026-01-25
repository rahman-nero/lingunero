<?php

namespace App\Repository;

use App\Models\LLMChatRoom;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Builder model()
 */
final class LLMChatRoomRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return LLMChatRoom::class;
    }

    /**
     * Получение всех чатов пользователя
     *
     * @param int $userId
     * @return Collection<LLMChatRoom>
     */
    public function all(int $userId): Collection
    {
        return $this->model()
            ->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Создан ли чат переданным пользователем.
     *
     * @param int $userId
     * @param int $id
     * @return bool
     */
    public function isChatBelongToUser(int $userId, int $id): bool
    {
        return $this->model()
            ->where('id', '=', $id)
            ->where('user_id', '=', $userId)
            ->exists();
    }
}
