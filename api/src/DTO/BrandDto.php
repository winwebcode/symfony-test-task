<?php

namespace App\DTO;

class BrandDto
{

    public function __construct(
        private int    $id,
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
} 