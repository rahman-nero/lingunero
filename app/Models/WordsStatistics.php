<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @param int $id
 * @param int $library_id
 * @param int $count_words
 * @param int $count_wrong
 * @param int $count_true
 * @param array $result
*/
class WordsStatistics extends Model
{
    use HasFactory;

    // TODO:
    protected $table = 'words_practice_statistics';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'result' => 'json'
    ];

}
