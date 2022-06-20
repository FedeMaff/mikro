<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;

class FakeEntityPerson implements EntityInterface
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $surname = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }
}
