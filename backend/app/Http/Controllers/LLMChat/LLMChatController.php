<?php

declare(strict_types=1);

namespace App\Http\Controllers\Chat;

use Illuminate\Support\Facades\Auth;

final class LLMChatController
{
    public function delete(int $chatId)
    {
        $user = Auth::user();


    }
}
