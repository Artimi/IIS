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
    protected $columns = array('id', 'donor', 'date', 'station', 'type');

    public function startup()
    {
        parent::startup();

        $this->invitation = $this->context->invitation;
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentInvitationGrid()
    {
        return new \BloodCenter\InvitationGrid($this->invitation, $this->default);
    }

    public function renderAddInvitation($donorid)
    {
        $this->defaultAddInvitation = array('donor' => $donorid);
    }

    public function createComponentAddInvitation($name)
    {
        $form = new \BloodCenter\InvitationForm($this->defaultAddInvitation);
        $form->onSuccess[] = callback($this, 'addInvitation');
        return $form;
    }

    public function addInvitation(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['state'] = 0; //in progress
        $this->invitation->insert($values);
        $this->flashMessage('Added invitation for donor ' . $values['donor']);
    }

}
