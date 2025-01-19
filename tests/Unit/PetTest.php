<?php

namespace Tests\Unit;

use App\Models\Pet;
use App\Models\Category;
use App\Models\Tag;
use App\Enums\PetStatus;
use PHPUnit\Framework\TestCase;

class PetTest extends TestCase
{
    /** @test */
    public function pet_model_initialization()
    {
        $category = new Category(id: 1, name: 'Dogs');
        $tags = [new Tag(id: 1, name: 'Friendly'), new Tag(id: 2, name: 'Cute')];


        $pet = new Pet(
            name: 'Doggie',
            photoUrls: ['http://example.com/dog.jpg'],
            id: 123,
            category: $category,
            tags: $tags,
            status: PetStatus::AVAILABLE
        );

        $this->assertEquals('Doggie', $pet->name);
        $this->assertEquals('Dogs', $pet->category?->name);
        $this->assertEquals('Friendly', $pet->tags[0]->name);
        $this->assertEquals(PetStatus::AVAILABLE, $pet->status);
    }
}
