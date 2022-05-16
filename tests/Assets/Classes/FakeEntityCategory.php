<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;
use MikroTest\Assets\Classes\FakeEntityColor as Color;

class FakeEntityCategory implements EntityInterface
{
    private ?int $id = null;
    private ?string $name = null;
    private ?Color $color = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setColor(Color $color): void
    {
        $this->color = $color;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }
}
