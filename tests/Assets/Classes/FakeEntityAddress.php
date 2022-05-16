<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;

class FakeEntityAddress implements EntityInterface
{
    private ?int $id = null;
    private ?string $address = null;
    private ?string $number = null;
    private ?string $city = null;
    private ?string $province = null;
    private ?int $zipCode = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setProvince(string $province): void
    {
        $this->province = $province;
    }

    public function setZipCode(int $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }
}
