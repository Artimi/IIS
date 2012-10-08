<?php


namespace DonorModule;

/**
 * Description of DonorPresenter
 *
 * @author Martin Simon <xsimon14@stud.fit.vutbr.cz>
 */
class DonorPresenter extends \DonorModule\BasePresenter
{
    private $donor;
    private $station;
    private $invitation;
    private $drawn;
    private $stationNames;
    private $default;
    private $columns = array('id', 'name', 'surname', 'blood_type', 'active', 'pref_station');
    private $awaitingInvitations;
    private $invitations;
    private $drawns;
    private $donorInfo;
    private $data = array();
    private $hasNewInvitations;
    private $hasConfirmedInvitations;
            
    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect(':Sign:in');
        }

        $this->donor = $this->context->donor;
        $this->station = $this->context->station;
        $this->invitation = $this->context->invitation;
        $this->drawn = $this->context->drawn;
        
        $this->stationNames = $this->station->getStationNames();
        $this->awaitingInvitations = $this->invitation->getInvitationsByDonor($this->user->getIdentity()->id,0);
        $this->invitations = $this->invitation->getInvitationsByDonor($this->user->getIdentity()->id,1);
        $this->drawns = $this->drawn->getDrawnsByDonor($this->user->getIdentity()->id);
        $this->donorInfo = $this->donor->getOneByID($this->user->getIdentity()->id);
        $this->hasNewInvitations = $this->invitation->hasInvitations($this->user->getIdentity()->id,0);
        $this->hasConfirmedInvitations = $this->invitation->hasInvitations($this->user->getIdentity()->id,1);
        
        $this->data['stationNames'] = $this->stationNames;
        $this->data['bloodTypes'] = $this->donor->bloodTypes;
    }

    public function renderDefault()
    {
        $query = $this->context->httpRequest->getQuery();
        $default = array();
        foreach ($query as $key => $value)
        {
            if (in_array($key, $this->columns))
                $default[$key] = $value;
        }
        $this->default = $default;
        
        $this->template->drawns = $this->drawns;
        $this->template->donorInfo = $this->donorInfo;
        $this->template->awaitingInvitations = $this->awaitingInvitations;
        $this->template->invitations = $this->invitations;
        $this->template->stationNames = $this->stationNames;
        $this->template->hasNewInvitations = $this->hasNewInvitations;
        $this->template->hasConfirmedInvitations = $this->hasConfirmedInvitations;
    }

    public function createComponentEdit()
    {
        $form = new \BloodCenter\DonorDetailForm($this->data, $this->donorInfo);
        $form['submit']->caption = 'Update';
        $form['national_id']->setAttribute('readonly');
        $form['blood_type']->setAttribute('readonly');
        $form['name']->setAttribute('readonly');
        $form['surname']->setAttribute('readonly');
        unset($form['note']); //user is not supposed to rwad the notes about him
        $presenter = $this;
        $form->addSubmit('cancel','Back')->setAttribute('class','ym-button')
                ->setValidationScope(FALSE)
                ->onClick[] = function () use ($presenter) {$presenter->redirect('Donor:');};
        $form->onSuccess[] = callback($this, 'donorEdited');
        return $form;
    }
    
    public function donorEdited(\BloodCenter\DonorDetailForm $form)
    {
        $values = $form->getValues();
        $this->donor->update($values, $values['id']);
        $this->flashMessage('Information has been update!');
    }
    
    public function renderInvitationDecline($id)
    {
        $this->flashMessage('Invitation #'. $id.' declined!');
        $this->invitation->update(array('state' => 2) ,$id);
        $this->redirect("Donor:");
    }
    
    public function renderInvitationConfirm($id)
    {
        $this->flashMessage('Invitation #'. $id.' confirmed!');
        $this->invitation->update(array('state' => 1) ,$id);
        $this->redirect("Donor:");
    }
}