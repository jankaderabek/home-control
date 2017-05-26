<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Security\IIdentity;

/**
 * @ORM\Entity
 */
class User implements IIdentity
{
    use Identifier;

    private const ROLE_REGISTERED = 'registered';

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Returns a list of roles that the user is a member of.
     * @return array
     */
    function getRoles()
    {
        return [self::ROLE_REGISTERED];
    }
}