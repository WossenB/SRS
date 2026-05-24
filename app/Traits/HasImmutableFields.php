<?php

namespace App\Traits;

trait HasImmutableFields
{
    protected static function bootHasImmutableFields()
    {
        static::updating(function ($model) {
            $immutable = $model->getImmutableFields() ?? [];
            foreach ($immutable as $field) {
                if ($model->isDirty($field)) {
                    throw new \Exception("Field [{$field}] is immutable and cannot be changed.");
                }
            }
        });
    }

    public function getImmutableFields(): array
    {
        return $this->immutableFields ?? [];
    }
}
