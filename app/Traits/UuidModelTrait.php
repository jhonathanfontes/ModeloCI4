<?php

namespace App\Traits;

trait UuidModelTrait
{
    public function findByUuid(string $uuid): ?object
    {
        return $this->where($this->table . '.UUID', $uuid)->first();
    }
}
