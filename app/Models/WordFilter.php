<?php

namespace App\Models;

use App\Enums\FilterWordTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'type',
    ];

    protected $casts = [
        'type' => FilterWordTypeEnum::class,
    ];
}
