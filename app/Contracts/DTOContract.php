<?php

namespace App\Contracts;

use Illuminate\Contracts\Support\Arrayable;

abstract class DTOContract implements Arrayable
{
    public function toArray(): array
    {
        throw new \Exception('Not implemented!');
        return [];
    }
}
