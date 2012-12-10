<?php

namespace NurseModule;

/**
 * Description of NursePresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class NursePresenter extends BasePresenter
{

    private $nurse;
    private $station;
    private $stationNames;
    private $data = array();
    protected $columns = array('id', 'name', 'surname', 'station', 'phone');
    private $defaultsDetail;

    protected function startup()
    {
        parent::startup();

        $this->nurse = $this->context->nurse;
        $this->station = $this->context->station;
        $this->stationNames = $this->station->getStationNames(TRUE);
        $this->data['stationNames'] = $this->station->getStationNames();
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentNurseGrid($name)
    {
        return new \BloodCenter\NurseGrid($this->nurse, $this->stationNames, $this->default);
    }

    public function renderDetail($id)
    {

        $defaults = $this->nurse->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\NurseDetailForm($this->data, $this->defaultsDetail);
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
        $form = new \BloodCenter\NurseDetailForm($this->data);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addNurse');
        unset($form['id']);        
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