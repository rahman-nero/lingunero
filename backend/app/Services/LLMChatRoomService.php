<?php

namespace App\Services;

use App\Models\LLMChatRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

final class LLMChatRoomService
{
    protected function getModel(): Builder
    {
        return LLMChatRoom::query();
    }

    /**
     * Создание новой чата.
     *
     * @param int $userId
     * @return LLMChatRoom
     */
    public function create(int $userId, ?string $title = null): LLMChatRoom
    {
        return $this->getModel()
            ->create([
                'user_id' => $userId,
                'title'   => $title ?? Carbon::now()
                        ->translatedFormat('j F Y H:i:s'),
            ]);
    }

    /**
     * Удаление чата с сообщениями.
     *
     * @param int $userId
     * @param int $chatId
     */
    public function delete(int $userId, int $chatId): void
    {
        /** @var LLMChatRoom $model */
        $model = $this->getModel()
            ->where('id', $chatId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $model->messages()
            ->delete();

        $model->delete();
    }
}
