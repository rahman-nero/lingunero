<?php

declare(strict_types=1);

namespace App\Http\Controllers\LLMChat;

use App\AI\Providers\ChatProvider;
use App\Http\Requests\LLMChat\Message\StoreRequest;
use App\Repository\LLMChatRoomRepository;
use App\Services\LLMChatMessageService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;

final class LLMChatMessageController
{
    /**
     * Спросить у LLM.
     *
     * @param int $chatId
     * @param StoreRequest $request
     * @param LLMChatRoomRepository $LLMChatRoomRepository
     * @param LLMChatMessageService $LLMChatMessageService
     * @param ChatProvider $chatProvider
     * @return string[]
     * @throws ConnectionException
     */
    public function store(
        int $chatId,
        StoreRequest $request,
        LLMChatRoomRepository $LLMChatRoomRepository,
        LLMChatMessageService $LLMChatMessageService,
        ChatProvider $chatProvider,
    )
    {
        $user = Auth::user();
        $data = $request->validated();

        if (!$LLMChatRoomRepository->isChatBelongToUser($user->id, $chatId)) {
            abort(404);
        }

        $response = nl2br($chatProvider->get(
            userId: $user->id,
            chatId: $chatId,
            message: $data['message']
        ));

        $LLMChatMessageService->create(
            chatRoomId: $chatId,
            message: $data['message'],
            reply: $response
        );

        return [
            'response' => $response,
        ];
    }
}
