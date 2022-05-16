<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;
use MikroTest\Assets\Classes\FakeEntityCategory as Category;
use MikroTest\Assets\Classes\FakeEntityShop as Shop;

class FakeEntityProduct implements EntityInterface
{
    /**
     * Lo slug è un valore dell'entità di sola lettura quindi non deve essere
     * parte del sistema di queryng automatizzato.
     * 
     * @var ?string $slug Etichetta di sola lettura
     * @global readonly
     */
    private ?string $slug = null;
    private ?int $id = null;
    private ?string $name = null;
    private float $price = 0.00;
    private ?Category $category = null;
    private array $shops =[];

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function setShops(Shop ...$shops): void
    {
        $this->shops = $shops;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getShops(): array
    {
        return $this->shops;
    }
}
