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
class InvitationPresenter extends \NurseModule\BasePresenter
{

    private $invitation;
    private $defaultAddInvitation;
    private $defaultsDetail;
    private $station;
    private $donor;
    private $nurse;
    private $stationNames;
    private $data = array();
    protected $columns = array('id', 'donor', 'date', 'station', 'type');

    public function startup()
    {
        parent::startup();

        $this->invitation = $this->context->invitation;
        $this->station = $this->context->station;
        $this->donor = $this->context->donor;
        $this->nurse = $this->context->nurse;
        $this->stationNames = $this->station->getStationNames(TRUE);
        $this->data['stationNames'] = $this->station->getStationNames();
        $this->data['donor'] = $this->donor->getIDs();
        $this->data['invitationState'] = $this->invitation->invitationState;
        
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentInvitationGrid()
    {
        return new \BloodCenter\InvitationGrid($this->invitation, $this->stationNames, $this->default);
    }

    public function renderAddInvitation($donor = NULL)
    {
        $nurse = $this->getUser()->id;
        $store = $this->nurse->getOneByID($nurse['station']);
        $this->defaultAddInvitation = array('store' => $store);
        if ($donor != NULL)
        {
            $this->defaultAddInvitation['donor'] = $donor;
        }
    }

    public function createComponentAddInvitation($name)
    {
        $form = new \BloodCenter\InvitationDetailForm($this->data, $this->defaultAddInvitation);
        $form->onSuccess[] = callback($this, 'addInvitation');
        unset($form['id']);
        return $form;
    }

    public function addInvitation(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['state'] = 0; //in progress
        $this->invitation->insert($values);
        $this->flashMessage('Added invitation for donor ' . $values['donor']);
    }

    public function renderDetail($id)
    {

        $defaults = $this->invitation->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\InvitationDetailForm($this->data, $this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'invitationEdited');
        return $form;
    }

    public function invitationEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->invitation->update($values, $values['id']);
        $this->flashMessage('Invitation ' . $values['id'] . ' was edited.');
    }

}
