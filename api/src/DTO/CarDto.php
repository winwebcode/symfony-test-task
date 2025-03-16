<?php

namespace App\DTO;

use App\Entity\Car;

class CarDto
{

    public function __construct(
        private int    $id,
        private string $brandName,
        private string $modelName,
        private string $photo,
        private int    $price,
    ) {
    }

    public static function createFromEntity(Car $car): self
    {
        return new self(
            id: $car->getId(),
            brandName: $car->getBrand()->getName(),
            modelName: $car->getModel()->getName(),
            photo: $car->getPhoto(),
            price: $car->getPrice()
        );
    }

    public function getBrandName(): string
    {
        return $this->brandName;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
} 