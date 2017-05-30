<?php declare(strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

abstract class BaseForm extends Control
{
    public function getTemplate(): Template
    {
        return parent::getTemplate();
    }
}