<?php

namespace App\Models;

use App\Enums\WordFilterTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $word
 * @property WordFilterTypeEnum $type
 * @property TelegramUser $telegramUser
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WordFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'type',
        'telegram_user_id',
    ];

    protected $casts = [
        'type' => WordFilterTypeEnum::class,
    ];

    public function telegramUser(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class);
    }
}
