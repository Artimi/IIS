<?php

namespace NurseModule;

/**
 * Description of StationPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class StationPresenter extends BasePresenter
{

    private $station;
    protected $columns = array('id', 'name', 'postal_code', 'city', 'street');
    private $defaultsDetail;
    
    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn() or !$this->user->isInRole('nurse'))
        {
            $this->flashMessage('You have to be signed in as a nurse.');
            $this->redirect(':Sign:in');
        }
        
        $this->station = $this->context->station;
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }
    
    public function renderAddStation()
    {
        
    }
    
    public function createComponentStationGrid($name)
    {
        return new \BloodCenter\StationGrid($this->station, $this->default);
    }

    public function createComponentAddStation($name)
    {
        $form = new \BloodCenter\StationDetailForm(NULL);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addStation');
        return $form;
    }

    public function addStation(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->station->insert($values);
        $this->flashMessage('Station ' . $values['name']. ' was added.');
    }
    
     public function renderDetail($id)
    {

        $defaults = $this->station->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\StationDetailForm($this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'stationEdited');
        return $form;
    }

    public function stationEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->station->update($values, $values['id']);
        $this->flashMessage('Station ' . $values['name'] . ' was edited.');
    }

}