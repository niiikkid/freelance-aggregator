<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $username
 * @property int $telegram_id
 * @property Collection<int, WordFilter> $wordFilters
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TelegramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'username',
        'telegram_id',
    ];

    public function wordFilters()
    {
        return $this->hasMany(WordFilter::class, 'telegram_user_id', 'id');
    }
}
