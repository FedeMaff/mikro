<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;

class FakeEntityUser implements EntityInterface
{
    private int $id = 0;
    private string $name = '';
    private string $surname = '';
    private int $n = 0;

    public function __construct(int $id, string $name, string $surname, int $n = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->n = $n;
    }

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

    public function setN(int $n): void
    {
        $this->n = $n;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getN(): int
    {
        return $this->n;
    }
}
