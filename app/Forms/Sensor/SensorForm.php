<?php declare(strict_types=1);


namespace App\Forms\Sensor;

use App\Entities\Project;
use App\Entities\Sensor;
use App\Exceptions\CannotGenerateNewSensorToken;
use App\Facades\SensorFacade;
use App\Forms\BaseForm;
use Nette\Forms\Form;

class SensorForm extends BaseForm
{

    /**
     * @var Project|null
     */
    private $project;

    /**
     * @var Sensor|null
     */
    private $sensor;

    /**
     * @var callable
     */
    private $onFormSuccess;

    /**
     * @var SensorFacade
     */
    private $sensorFacade;

    public function __construct(?Project $project, ?Sensor $sensor = null, SensorFacade $sensorFacade)
    {
        parent::__construct();
        $this->project = $project;
        $this->sensor = $sensor;
        $this->sensorFacade = $sensorFacade;
    }

    public function createComponentForm()
    {
        $form = new Form();
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addHidden('id');
        $form->addHidden('project');

        $form->addText('name', 'Název')
            ->setRequired('Zadejte prosím název.');

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = [$this, 'onSuccess'];

        $this->setDefaults($form);

        return $form;
    }

    public function render()
    {
        $this->getTemplate()->render(__DIR__ . '/SensorForm.latte');
    }

    public function onSuccess(Form $form, $values)
    {
        $sensor = $this->processForm($form, $values);

        if ($sensor) {
            ($this->onFormSuccess)($sensor);
        }
    }

    public function setOnFormSuccess(callable $function)
    {
        $this->onFormSuccess = $function;
    }

    private function processForm(Form $form, $values): ?Sensor
    {
        if ( ! empty($values->id)) {
            return $this->sensorFacade->editProject((int) $values->id, $values->name);
        }

        try {
            return $this->sensorFacade->createSensor($values->name, $values->project);
        } catch (CannotGenerateNewSensorToken $exception) {
            $form->addError('Nepodařilo se vygenerovat přístupový klíč');
        }

        return null;
    }

    private function setDefaults(Form $form): void
    {
        $project = $this->project ?: ($this->sensor ? $this->sensor->getProject() : null);

        if ($project) {
            $form['project']->setDefaultValue($this->project->getId());
        }

        if ($this->sensor) {
            $form['id']->setDefaultValue($this->sensor->getId());
            $form['name']->setDefaultValue($this->sensor->getId());
        }
    }
}
