<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand extends BaseEntity
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="brand")
     */
    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'brand')]
    private Collection $cars;

    /**
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="brand")
     */
    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: 'brand')]
    private Collection $models;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->models = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setBrand($this);
        }
        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getBrand() === $this) {
                $car->setBrand(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }
}
