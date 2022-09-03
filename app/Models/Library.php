<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 *
 */
class Library extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function words()
    {
        return $this->belongsTo(Words::class, 'id', 'library_id');
    }

    public function sentences()
    {
        return $this->belongsTo(Sentence::class, 'id', 'library_id');
    }

    public function wordsStatistics()
    {
        return $this->hasMany(WordsStatistics::class, 'library_id', 'id');
    }

    public function sentencesStatistics()
    {
        return $this->hasMany(SentencesPractice::class, 'library_id', 'id');
    }

    public function countWords()
    {
        return $this->words()->count();
    }

    public function countSentences()
    {
        return $this->sentences()->count();
    }

}
