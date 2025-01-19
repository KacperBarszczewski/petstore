<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Tag;
use App\Enums\PetStatus;
class Pet
{
    public ?int $id;
    public string $name;
    public array $photoUrls;
    public ?Category $category;
    public ?Tag $tags;
    public ?PetStatus $status;

    public function __construct(
        string $name,
        array $photoUrls,
        ?int $id = null,
        ?Category $category = null,
        ?Tag $tags = null,
        ?PetStatus $status = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photoUrls = $photoUrls;
        $this->category = $category;
        $this->tags = $tags;
        $this->status = $status;
    }
}
