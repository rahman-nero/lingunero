<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentencesPractice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = true;

    protected $table = 'sentences_practices_statistics';

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
