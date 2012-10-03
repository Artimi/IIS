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
    //private $defaultsDetail;
    private $stationNames;
    private $default;
    private $columns = array('id', 'name', 'surname', 'blood_type', 'active', 'pref_station');
    private $awaitingInvitations;
    private $drawns;
    private $donorInfo;
    private $data = array();
    private $hasInvitations;
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
        $this->awaitingInvitations = $this->invitation->getInvitationsByDonor($this->user->getIdentity()->id);
        $this->drawns = $this->drawn->getDrawnsByDonor($this->user->getIdentity()->id);
        $this->donorInfo = $this->donor->findOneById($this->user->getIdentity()->id);
        $this->hasInvitations = $this->invitation->hasInvitations($this->user->getIdentity()->id);
        
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
        $this->template->stationNames = $this->stationNames;
        $this->template->hasInvitations = $this->hasInvitations;
    }


    public function createComponentEdit()
    {
        $form = new \BloodCenter\DonorDetailForm($this->data, $this->donorInfo);
        $form['submit']->caption = 'Update';
        $form['national_id']->setAttribute('readonly');
        $form['blood_type']->setAttribute('readonly');
        $form['name']->setAttribute('readonly');
        $form['surname']->setAttribute('readonly');
        unset($form['note']);
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
        $this->flashMessage('Invitation declined!');
        $this->redirect("Donor:");
    }
    /*
    public function renderDetail($id)
    {

        $defaults = $this->donor->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\DetailForm($this->defaultsDetail, $this->stationNames);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'donorEdited');
        return $form;
    }

    public function donorEdited(Form $form)
    {
        $values = $form->getValues();
        $this->donor->update($values, $values['id']);
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['id'] . ') was edited.');
    }

    public function renderAddDonor()
    {
        
    }

    public function createComponentAddDonor($name)
    {
        $form = new \BloodCenter\DetailForm(NULL, $this->stationNames);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addDonor');
        return $form;
    }

    public function addDonor(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['id'] = $this->donor->generateNick($values['surname']);
        $this->donor->insert($values);
        $this->donor->setPassword($values['id'], '123');
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['id'] . ') was added.');
    }

    public function renderDrawn($donorid)
    {
        $this->template->drawns = $this->drawn->findBy(array('donor' => $donorid));
        $this->template->donorid = $donorid;
    }

    public function createComponentDonorGrid($name)
    {
        return new \BloodCenter\DonorGrid($this->donor, $this->default);
    }
    */
}

