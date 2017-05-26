<?php declare(strict_types = 1);

namespace App\Facades;

use App\Entities\User;
use App\Exceptions\UserAlreadyExistsException;
use App\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Nette\Security\Passwords;

class UserFacade
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        EntityManager $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function createUser(string $email, string $password): User
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new UserAlreadyExistsException($email);
        }

        $user = new User($email, Passwords::hash($password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}