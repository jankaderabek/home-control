<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Value
{
    use Identifier;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $value;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @var Sensor
     * @ORM\ManyToOne(targetEntity=Sensor::class, inversedBy="values")
     */
    protected $sensor;

    public function __construct(float $value, Sensor $sensor)
    {
        $this->value = $value;
        $this->sensor = $sensor;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    public function getSensor(): Sensor
    {
        return $this->sensor;
    }
}