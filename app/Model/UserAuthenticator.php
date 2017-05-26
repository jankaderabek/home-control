<?php declare(strict_types=1);

namespace App\Model;

use App\Entities\User;
use App\Repositories\UserRepository;
use Nette;
use Nette\Security\Passwords;

class UserAuthenticator implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    const
    TABLE_NAME = 'users',
    COLUMN_ID = 'id',
    COLUMN_NAME = 'username',
    COLUMN_PASSWORD_HASH = 'password',
    COLUMN_EMAIL = 'email',
    COLUMN_ROLE = 'role';

    /**
     * @var UserRepository
     */
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $user = $this->userRepository->findByEmail($username);

        if (!$user) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

        } elseif (!Passwords::verify($password, $user->getPassword())) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($user->getPassword())) {
            $user->setPassword(Passwords::hash($password));
            $this->userRepository->getEntityManager()->flush();
        }

        return $user;
    }
}
