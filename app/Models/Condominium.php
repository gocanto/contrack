<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property Block[]|Collection blocks
 * @property string name
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Condominium extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'condominiums';
    protected $fillable = ['uuid', 'name'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }
}
