<?php

namespace NurseModule;

/**
 * Description of NursePresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class NursePresenter extends BasePresenter
{

    private $nurse;
    protected $columns = array('id', 'name', 'surname', 'station', 'phone');
    private $defaultsDetail;

    protected function startup()
    {
        parent::startup();

        $this->nurse = $this->context->nurse;
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentNurseGrid($name)
    {
        return new \BloodCenter\NurseGrid($this->nurse, $this->default);
    }

    public function renderDetail($id)
    {

        $defaults = $this->nurse->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\NurseDetailForm($this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'nurseEdited');
        return $form;
    }

    public function nurseEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->nurse->update($values, $values['id']);
        $this->flashMessage('Nurse ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['id'] . ') was edited.');
    }

    public function renderAddNurse()
    {
        
    }

    public function createComponentAddNurse($name)
    {
        $form = new \BloodCenter\NurseDetailForm(NULL);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addNurse');
        $form['id']->setDisabled();
        return $form;
    }

    public function addNurse(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['id'] = $this->nurse->generateNick($values['surname']);
        $this->nurse->insert($values);
        $this->nurse->setPassword($values['id'], '123');
        $this->flashMessage('Nurse ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['id'] . ') was added.');
    }

}