<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string phone_number
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 * @method static create(array $getAttributes)
 */
class Tenant extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'phone_number',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
