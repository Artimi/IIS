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
    private $nurse;
    private $station;
    
    public function startup()
    {
        parent::startup();
        $this->drawn = $this->context->drawn;
        $this->station = $this->context->station;
        $this->nurse = $this->context->nurse;
    }

    public function renderDetail($id)
    {
        $this->template->drawnInfo = $this->drawn->getOneById($id);
        $this->template->stationNames = $this->station->getStationNames();
        $this->template->nurseInfo = $this->nurse->getOneById($this->template->drawnInfo->nurse);
    }
}