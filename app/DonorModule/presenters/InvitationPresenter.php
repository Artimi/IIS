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
        //$this->template->stationNames = $this->station->getStationNames();
    }
    
    public function createComponentInvitationGrid()
    {
        //FIXME!!! pouze od jednoho autora
        //FIXME!!! odkaz spravit
        //FIXME!!! odstranit AddInvitation
        $form = new \BloodCenter\InvitationGrid($this->invitation, $this->stationNames);
        return $form;
    }
}