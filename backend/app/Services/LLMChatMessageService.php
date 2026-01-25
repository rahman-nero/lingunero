<?php

namespace App\Services;

use App\Models\LLMChatMessage;
use App\Models\LLMChatRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

final class LLMChatMessageService
{
    protected function getModel(): Builder
    {
        return LLMChatMessage::query();
    }

    /**
     * Добавление сообщения.
     *
     * @param int $chatRoomId
     * @param string $message
     * @param string|null $reply
     * @return LLMChatMessage
     */
    public function create(
        int $chatRoomId,
        string $message,
        ?string $reply,
    ): LLMChatMessage
    {
        return $this->getModel()
            ->create([
                'chat_room_id'   => $chatRoomId,
                'message'        => $message,
                'reply'          => $reply,
                'reply_given_at' => $reply ? Carbon::now()
                    ->toDateTimeString() : null,
            ]);
    }
}
