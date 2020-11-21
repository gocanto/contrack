<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string uuid
 * @property string visitor_first_name
 * @property string visitor_last_name
 * @property string phone_number
 * @property string nric_last_r
 * @property int unit_id
 * @property int block_id
 * @property int condominium_id
 * @property Unit|null unit
 * @property Block|null block
 * @property Condominium|null condominium
 * @property Carbon|null arrived_at
 * @property Carbon|null left_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static create(array $data)
 */
class Visit extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'visitor_first_name',
        'visitor_last_name',
        'phone_number',
        'nric_last_r',
        'unit_id',
        'block_id',
        'condominium_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'arrived_at', 'left_at'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function condominium(): BelongsTo
    {
        return $this->belongsTo(Condominium::class);
    }
}
