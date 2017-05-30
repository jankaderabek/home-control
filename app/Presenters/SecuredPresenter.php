<?php declare(strict_types=1);

namespace App\Presenters;

use App\Entities\User;
use Nette\Http\IResponse;

abstract class SecuredPresenter extends BasePresenter
{
    protected function startup()
    {
        parent::startup();

        $isLoggedIn = $this->getUser()->isLoggedIn();

        if (!$isLoggedIn) {
            $this->error(null, IResponse::S403_FORBIDDEN);
        }
    }

    public function getApplicationUser(): User
    {
        /** @var $user User */
        $user = $this->getUser()->getIdentity();

        return $user;
    }
}