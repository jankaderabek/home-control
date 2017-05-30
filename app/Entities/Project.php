<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Project
{
    use Identifier;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $token;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist"})
     */
    protected $user;

    /**
     * @var Sensor[]
     * @ORM\OneToMany(targetEntity=Sensor::class, mappedBy="project")
     */
    protected $sensors;

    public function __construct(string $token, string $name, User $user)
    {
        $this->token = $token;
        $this->name = $name;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Sensor[]|ArrayCollection
     */
    public function getSensors(): ArrayCollection
    {
        return $this->sensors;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}