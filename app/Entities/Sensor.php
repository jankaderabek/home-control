<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Sensor
{
    use Identifier;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    protected $identifier;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="sensors", cascade={"persist"}))
     */
    protected $project;

    /**
     * @var Value[]
     * @ORM\OneToMany(targetEntity=Value::class, mappedBy="sensor")
     */
    protected $values;

    public function __construct(string $identifier, string $name, Project $project)
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->project = $project;
        $this->values = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return Value[]|ArrayCollection
     */
    public function getValues(): ArrayCollection
    {
        return $this->values;
    }
}