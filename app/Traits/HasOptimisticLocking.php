<?php

namespace App\Traits;

use App\Exceptions\ConcurrentModificationException;

trait HasOptimisticLocking
{
    public static function bootHasOptimisticLocking()
    {
        static::updating(function ($model) {
            $originalVersion = $model->getOriginal('version');

            if ($model->version !== $originalVersion) {
                throw new ConcurrentModificationException();
            }

            $model->version++;
        });
    }
}
