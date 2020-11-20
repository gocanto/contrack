<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Tenant|null tenant
 * @property int|null tenant_id
 * @property Visit[]|Collection visits
 * @property int id
 * @property string number
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 * @property Condominium condominium
 * @property Block block
 * @method static create(array $attributes)
 */
class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'number',
        'condominium_id',
        'block_id',
        'tenant_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function condominium(): BelongsTo
    {
        return $this->belongsTo(Condominium::class);
    }

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class, 'id', 'tenant_id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'unit_id');
    }

    public function rent(Tenant $tenant): void
    {
        $this->tenant_id = $tenant->id;
        $this->save();
    }

    public function getCurrentVisitors(): Collection
    {
        return $this->visits()
            ->whereNotNull('arrived_at')
            ->whereNull('left_at')
            ->get();
    }

    public function isRented(): bool
    {
        return $this->tenant_id !== null;
    }
}
