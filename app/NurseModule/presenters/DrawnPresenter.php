<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace NurseModule;
/**
 * Description of DrawnPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnPresenter extends \NurseModule\BasePresenter
{

    private $drawn;
    private $donor;
    private $nurse;
    private $defaultAddDrawn;
    private $defaultsDetail;
    private $stationNames;
    private $data = array();
    protected $columns = array('id', 'date', 'donor', 'blood_type', 'nurse', 'store', 'reservation', 'quality');

    public function startup()
    {
        parent::startup();

        $this->drawn = $this->context->drawn;
        $this->donor = $this->context->donor;
        $this->nurse = $this->context->nurse;
        $this->stationNames = $this->context->station->getStationNames(TRUE);
        $this->data['stationNames'] = $this->context->station->getStationNames();
        $this->data['bloodTypes'] = $this->context->drawn->bloodTypes;
        $this->data['donors'] = $this->donor->getIDs();
        $this->data['nurses'] = $this->nurse->getIDs();
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentDrawnGrid()
    {
        return new \BloodCenter\DrawnGrid($this->drawn, $this->stationNames, $this->default);
    }

    public function renderAddDrawn($donor=NULL)
    {
        $nurse = $this->getUser()->id;
        $store = $this->nurse->findOneByID($nurse['station']);
        $this->defaultAddDrawn = array(
            'date' => date('Y-m-d H-i-s'),
            'nurse' => $nurse,
            'store' => $store);
        if ($donor != NULL)
        {
            $this->defaultAddDrawn['donor'] = $donor;
        }
    }

    public function createComponentAddDrawn($name)
    {
        $form = new \BloodCenter\DrawnDetailForm($this->data, $this->defaultAddDrawn);
        $form->onSuccess[] = callback($this, 'addDrawn');
        $form['id']->setDisabled();
        return $form;
    }

    public function addDrawn(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        if ($values['reservation'] == '') //TODO little hack to avoid foreign_key error
            $values['reservation'] = NULL;
        $this->drawn->insert($values);
        $this->flashMessage('Added drawn of donor ' . $values['donor']);
    }

     public function renderDetail($id)
    {

        $defaults = $this->drawn->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\DrawnDetailForm($this->data, $this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'drawnEdited');
        return $form;
    }

    public function drawnEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        if ($values['reservation'] == '') //TODO little hack to avoid foreign_key error
            $values['reservation'] = NULL;
        $this->drawn->update($values, $values['id']);
        $this->flashMessage('Drawn '  . $values['id'] . ' was edited.');
    }
}
