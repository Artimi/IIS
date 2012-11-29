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
    public function startup()
    {
        parent::startup();
        $this->station = $this->context->station;
    }

    public function renderDetail($station)
    {
        $this->template->stationInfo = $this->station->getOneById($station);
        $this->template->stations = $this->station->findAll();
        $this->template->param = $station;
    }
    
    public function createComponentStationsForm($name)
    {
        $stations = array();
        foreach ($this->station->getIDs() as $id)
        {
            $stations[$id] = $this->station->findOneBy(array('id' => $id))->name;
        }
        $form = new \Nette\Application\UI\Form($this, $name);
        $form->addSelect('station', 'Choose a station you want to see', $stations);
        $form->addSubmit('submit', 'See station details')
            ->setAttribute('class','ym-button');
        $form->onSuccess[] = callback($this, 'chooseStation');
        return $form;
    }
    
    public function chooseStation(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->redirect('Station:detail', $values['station']);
    }
}