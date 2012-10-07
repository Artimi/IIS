<?php


namespace DonorModule;

/**
 * Description of DonorPresenter
 *
 * @author Martin Simon <xsimon14@stud.fit.vutbr.cz>
 */
class StationPresenter extends \DonorModule\BasePresenter
{
    private $station;
    //private $stationInfo;
    //private $stations;
    
    public function startup()
    {
        parent::startup();
        $this->station = $this->context->station;
    }

    public function renderDetail($station)
    {
        $this->template->stationInfo = $this->station->getStationById($station);
        $this->template->stations = $this->station->getStationNames();
    }
}