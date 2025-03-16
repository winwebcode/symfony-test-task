<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car extends BaseEntity
{

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private Brand $brand;

    #[ORM\Column(type: 'string', length: 255)]
    private string $photo;

    #[ORM\Column(type: 'integer')]
    private int $price;

    #[ORM\ManyToOne(targetEntity: Model::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Model $model;

    #[ORM\OneToMany(targetEntity: CreditRequest::class, mappedBy: 'car')]
    private Collection $creditRequests;

    public function __construct()
    {
        $this->creditRequests = new ArrayCollection();
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Collection<int, CreditRequest>
     */
    public function getCreditRequests(): Collection
    {
        return $this->creditRequests;
    }

    public function addCreditRequest(CreditRequest $creditRequest): self
    {
        if (!$this->creditRequests->contains($creditRequest)) {
            $this->creditRequests->add($creditRequest);
            $creditRequest->setCar($this);
        }
        return $this;
    }

    public function removeCreditRequest(CreditRequest $creditRequest): self
    {
        if ($this->creditRequests->removeElement($creditRequest)) {
            if ($creditRequest->getCar() === $this) {
                $creditRequest->setCar(null);
            }
        }
        return $this;
    }
}
