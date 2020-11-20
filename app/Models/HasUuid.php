<?php

declare(strict_types=1);

namespace App\Models;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(static function ($model) {
            if ($model->uuid === null) {
                $model->uuid = (string) Uuid::uuid4();
            }
        });
    }
}
