<?php


namespace DonorModule;

/**
 * Description of DonorPresenter
 *
 * @author Martin Simon <xsimon14@stud.fit.vutbr.cz>
 */
class DrawnPresenter extends \DonorModule\BasePresenter
{
    private $drawn;
    //private $drawnInfo;
    private $station;
    
    public function startup()
    {
        parent::startup();
        $this->drawn = $this->context->drawn;
        $this->station = $this->context->station;
    }

    public function renderDetail($id)
    {
        //$this->template->stationInfo = $this->station->getStationById($station);
        $this->template->drawnInfo = $this->drawn->getDrawnById($id);
        $this->template->stationNames = $this->station->getStationNames();
    }
}