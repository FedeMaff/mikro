<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;
use MikroTest\Assets\Classes\FakeEntityAddress as Address;

class FakeEntityShop implements EntityInterface
{
    private ?int $id = null;
    private ?string $name = null;
    private ?Address $address = null;
    private ?float $revenue = null;
    private int $n = 0;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function setRevenue(float $revenue): void
    {
        $this->revenue = $revenue;
    }

    public function setN(int $n): void
    {
        $this->n = $n;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function getRevenue(): ?float
    {
        return $this->revenue;
    }

    public function getN(): int
    {
        return $this->n;
    }
}
