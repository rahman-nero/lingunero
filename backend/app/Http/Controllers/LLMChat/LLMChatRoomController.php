<?php

declare(strict_types=1);

namespace App\Http\Controllers\LLMChat;

use App\Repository\LLMChatMessagesRepository;
use App\Repository\LLMChatRoomRepository;
use App\Services\LLMChatRoomService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class LLMChatRoomController
{
    /**
     * Получение всех чатов.
     *
     * @param LLMChatRoomRepository $LLMChatRoomRepository
     *
     */
    public function index(
        LLMChatRoomRepository $LLMChatRoomRepository
    )
    {
        $user = Auth::user();

        $chats = $LLMChatRoomRepository->all($user->id);

        return view('site.llm.chats.index', compact('user', 'chats'));
    }

    /**
     * Получение конкретного чата.
     *
     * @param LLMChatRoomRepository $LLMChatRoomRepository
     * @param LLMChatMessagesRepository $LLMChatMessagesRepository
     * @param int $id
     * @return Factory|View|\Illuminate\View\View
     */
    public function show(
        LLMChatRoomRepository $LLMChatRoomRepository,
        LLMChatMessagesRepository $LLMChatMessagesRepository,
        int $id
    )
    {
        $user = Auth::user();

        if (!$LLMChatRoomRepository->isChatBelongToUser($user->id, $id)) {
            abort(404);
        }

        $chats = $LLMChatRoomRepository->all($user->id);
        $messages = $LLMChatMessagesRepository->all($user->id, $id);
        $currentChat = $chats->where('id', $id)->firstOrFail();

        return view('site.llm.chats.show', compact('id', 'user', 'chats', 'messages', 'currentChat'));
    }

    /**
     * Создание чата.
     *
     * @param LLMChatRoomService $LLMChatRoomService
     * @return RedirectResponse
     */
    public function store(
        LLMChatRoomService $LLMChatRoomService,
    ): RedirectResponse
    {
        $user = Auth::user();

        $result = $LLMChatRoomService->create($user->id);

        return to_route('llm.chats.show', ['chat_id' => $result->id]);
    }

    /**
     * Удаление чата.
     *
     * @param int $chatId
     * @param LLMChatRoomService $LLMChatRoomService
     * @return RedirectResponse
     */
    public function delete(
        int $chatId,
        LLMChatRoomService $LLMChatRoomService,
    ): RedirectResponse
    {
        $user = Auth::user();

        $LLMChatRoomService->delete($user->id, $chatId);

        return to_route('llm.chats.index');
    }
}
