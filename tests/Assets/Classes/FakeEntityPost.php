<?php

namespace MikroTest\Assets\Classes;

use Mikro\Entity\EntityInterface;
use MikroTest\Assets\Classes\FakeEntityUser;

class FakeEntityPost implements EntityInterface
{
    private ?int $id = null;
    private ?string $name = null;

    /**
     * Istanza utente Variadic Readonly
     * 
     * @var ?FakeEntityUser $user Istanza utente
     * 
     * @global readonly
     */
    private ?FakeEntityUser $user = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setUser(FakeEntityUser $user): void
    {
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUser(): ?FakeEntityUser
    {
        return $this->user;
    }
}
