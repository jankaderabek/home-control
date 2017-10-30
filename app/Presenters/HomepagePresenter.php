<?php

namespace App\Presenters;

use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
	public function actionDefault()
	{
		\Tracy\Debugger::log('Test' . (new \DateTime())->format('Y-m-d H:i:s'), \Tracy\ILogger::ERROR);
	}
}
