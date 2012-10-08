<?php


namespace DonorModule;

/**
 * Description of InvitationPresenter
 *
 * @author Martin Simon <xsimon14@stud.fit.vutbr.cz>
 */
class InvitationPresenter extends \DonorModule\BasePresenter
{
    private $station;
    private $invitation;
    private $stationNames;
    
    public function startup()
    {
        parent::startup();
        $this->invitation = $this->context->invitation;
        $this->station = $this->context->station;
        $this->stationNames = $this->station->getStationNames(TRUE);
    }

    public function renderAll($id)
    {
        $this->template->stationNames = $this->station->getStationNames();
        $this->template->invitations = $this->invitation->getInvitationsByDonor($this->user->getIdentity()->id);
        $this->template->hasInvitations = $this->invitation->hasInvitations($this->user->getIdentity()->id);
        $this->template->invitationState = $this->invitation->invitationState;
    }
}

