<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property Condominium condominium
 * @property int id
 * @property Unit[]|Collection units
 * @property string number
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Block extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = ['uuid', 'number', 'condominium_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function condominium(): BelongsTo
    {
        return $this->belongsTo(Condominium::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function hasUnit(Unit $unit): bool
    {
        return $this->units
            ->where('id', $unit->id)
            ->isNotEmpty();
    }

    public function doestNotHave(Unit $unit): bool
    {
        return !$this->hasUnit($unit);
    }
}
