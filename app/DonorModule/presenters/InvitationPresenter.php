<?php


namespace DonorModule;

/**
 * Description of InvitationPresenter
 *
 * @author Martin Simon <xsimon14@stud.fit.vutbr.cz>
 */
class InvitationPresenter extends \DonorModule\BasePresenter
{
    //private $drawn;
    //private $drawnInfo;
    
    private $station;
    private $invitation;
    private $stationNames;
    
    public function startup()
    {
        parent::startup();
        //$this->drawn = $this->context->drawn;
        //$this->station = $this->context->station;
        $this->invitation = $this->context->invitation;
        $this->station = $this->context->station;
        $this->stationNames = $this->station->getStationNames(TRUE);
    }

    public function renderAll($id)
    {
        //$this->template->stationInfo = $this->station->getStationById($station);
        //$this->template->drawnInfo = $this->drawn->getDrawnById($id);
        $this->template->stationNames = $this->station->getStationNames();
        $this->template->invitations = $this->invitation->getInvitationsByDonor($this->user->getIdentity()->id);
        $this->template->hasInvitations = $this->invitation->hasInvitations($this->user->getIdentity()->id);
        $this->template->invitationState = $this->invitation->invitationState;
    }
    
    /*public function createComponentAllInvitations()
    {
        //FIXME!!! pouze od jednoho autora
        //FIXME!!! odkaz spravit
        //FIXME!!! odstranit AddInvitation
        $form = new \NiftyGrid\Grid();
       
        return $form;
    }*/
    
}

