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
        if(!$this->user->isLoggedIn()  or !$this->user->isInRole('nurse'))
        {
            $this->flashMessage('You have to be signed in as a nurse.');
            $this->redirect(':Sign:in');
        }

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

    public function addInvitation(Form $form)
    {
        $values = $form->getValues();
        $this->invitation->insert($values);
        $this->flashMessage('Added invitation for donor ' . $values['donor']);
    }

}
