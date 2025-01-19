<?php

namespace App\Models;

class Tag
{
    public ?int $id;
    public ?string $name;

    public function __construct(?int $id = null, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
