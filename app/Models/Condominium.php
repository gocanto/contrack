<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property Block[]|Collection blocks
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
