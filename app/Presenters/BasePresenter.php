<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;

abstract class BasePresenter extends Presenter
{
    public function getTemplate(): Template
    {
        return parent::getTemplate();
    }
}