<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Condominium extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name'];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }
}
