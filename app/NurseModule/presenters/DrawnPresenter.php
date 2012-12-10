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
    private $reservation;
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
        $this->reservation = $this->context->reservation;
        $this->stationNames = $this->context->station->getStationNames(TRUE);
        $this->data['stationNames'] = $this->context->station->getStationNames();
        $this->data['bloodTypes'] = $this->context->drawn->bloodTypes;
        $this->data['donors'] = $this->donor->getIDs();
        $this->data['nurses'] = $this->nurse->getIDs();
        $this->data['reservation'] = $this->reservation->getReservationArray();
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
        $store = $this->nurse->getOneByID($nurse['station']);
        $this->defaultAddDrawn = array(
            'date' => date('Y-m-d H-i-s'),
            'nurse' => $nurse,
            'store' => $store);
        if ($donor != NULL)
        {
            $this->defaultAddDrawn['donor'] = $donor;
            $donor_all = $this->donor->getOneByID($donor);
            $this->defaultAddDrawn['blood_type'] = $donor_all['blood_type']; 
        }
    }

    public function createComponentAddDrawn($name)
    {
        $form = new \BloodCenter\DrawnDetailForm($this->data, $this->defaultAddDrawn);
        $form->onSuccess[] = callback($this, 'addDrawn');
        unset($form['id']);
        return $form;
    }

    public function addDrawn(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        //the blood type has to be consistent with donor -> shouldn't be on user's choice
        //xsebek02: long long times ago we said that donor blood_type will be
        //other check/control that it is the right donor. It is possible that
        //somebody let go his friend instead of him and of course we will assume
        //same blood_type and someone else can die because of this assumption.
        //I would let it the way it is.
        $values['blood_type'] = $this->donor->findOneBy(array('id' => $values['donor']))->blood_type;
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
        //the blood type has to be consistent with donor -> shouldn't be on user's choice
        $values['blood_type'] = $this->donor->findOneBy(array('id' => $values['donor']))->blood_type;
        $this->drawn->update($values, $values['id']);
        $this->flashMessage('Drawn '  . $values['id'] . ' was edited.');
    }
}
