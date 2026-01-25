<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 */
class LLMChatRoom extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @inheritdoc */
    protected $table = 'llm_chat_rooms';

    /** @inheritdoc */
    protected $fillable = [
        'user_id',
        'title',
    ];

    /**
     * К какому пользователю принадлежит чат.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Сообщения чата.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(LLMChatMessage::class, 'chat_room_id');
    }
}
