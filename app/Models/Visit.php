<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'arrived_at', 'left_at'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
