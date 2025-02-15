<?php

namespace App\DTO;

use App\Entity\Car;

class CarDto
{

    public int $id;

    public string $photo;

    public int $price;

    public BrandDto $brand;

    public ModelDto $model;

    public function __construct(int $id, string $photo, int $price, BrandDto $brand, ModelDto $model)
    {
        $this->id    = $id;
        $this->photo = $photo;
        $this->price = $price;
        $this->brand = $brand;
        $this->model = $model;
    }

    public static function createFromEntity(Car $car): self
    {
        $brandDto = new BrandDto($car->getBrand()->getId(), $car->getBrand()->getName());
        $modelDto = new ModelDto($car->getModel()->getId(), $car->getModel()->getName());

        return new self($car->getId(), $car->getPhoto(), $car->getPrice(), $brandDto, $modelDto);
    }
} 