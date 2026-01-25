<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $chat_room_id
 * @property string $message
 * @property ?string $reply
 * @property ?Carbon $reply_given_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 */
class LLMChatMessage extends Model
{
    use HasFactory;
    use softDeletes;

    /** @inheritdoc */
    protected $table = 'llm_chat_messages';

    /** @inheritdoc */
    protected $fillable = [
        'chat_room_id',
        'message',
        'reply',
        'reply_given_at',
    ];

    /**
     * @return BelongsTo
     */
    public function chatRoom(): BelongsTo
    {
        return $this->belongsTo(LLMChatRoom::class, 'chat_room_id');
    }
}
