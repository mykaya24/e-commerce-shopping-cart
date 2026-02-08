<?php

namespace App\Models;

class Category implements \JsonSerializable
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $slug
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}