<?php

namespace App\Models;

use App\Enums\FreelanceEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property FreelanceEnum $freelance
 * @property string $title
 * @property string $link
 * @property string $description
 * @property string $category
 * @property Carbon $published_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelance',
        'title',
        'link',
        'description',
        'category',
        'published_at',
    ];

    protected $casts = [
        'freelance' => FreelanceEnum::class,
        'published_at' => 'datetime',
    ];
}