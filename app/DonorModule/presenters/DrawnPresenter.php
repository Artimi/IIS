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
    //private $stationInfo;
    
    public function startup()
    {
        parent::startup();
        $this->drawn = $this->context->drawn;
    }

    public function renderDetail($id)
    {
        //$this->template->stationInfo = $this->station->getStationById($station);
    }
}