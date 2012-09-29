<?php

namespace NurseModule;

/**
 * Description of DonorPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DonorPresenter extends \NurseModule\BasePresenter
{
    private $donor;
    private $drawn;
    private $station;
    private $invitation;
    private $donorInfo;
    private $selectDrawnsByUser;
    
    
    protected function startup()
    {
        parent::startup();
        $this->donor = $this->context->donor;
        $this->drawn = $this->context->drawn;
        $this->station = $this->context->station;
        $this->invitation = $this->context->invitation;
        
    }

    public function renderDefault()
    {
        
    }
    
    public function createComponentDonorForm($name)
    {
        $form = new \Nette\Application\UI\Form($this, $name);
        $form->addSelect('donor', 'Donor', $this->donor->getIDs());
        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = callback($this, 'chooseDonor');
        return $form;
    }
    
    public function chooseDonor(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->donorInfo = $this->donor->findOneByID($values['donor']);
        $this->template->donorInfo = $this->donorInfo;
        $this->template->selectDrawnsByUser= $this->drawn->getDrawnsById($values['donor']);
        $this->template->stationNames = $this->station->getStationNames();
        $this->template->invitations = $this->invitation->findBy(array('donor' => $values['donor']));
        $this->template->invitationState = $this->invitation->invitationState;
        
    }

}