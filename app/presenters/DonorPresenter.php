<?php

use Nette\Application\UI\Form;

/**
 * Description of DonorPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DonorPresenter extends BasePresenter
{

    private $donor;
    private $station;
    private $invitation;

    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect('Sign:in');
        }

        $this->donor = $this->context->donor;
        $this->station = $this->context->station;
        $this->invitation = $this->context->invitation;
    }

    public function renderDefault()
    {
        
    }

    public function createComponentDonorsList()
    {
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect('Sign:in');
        }
        return new BloodCenter\DonorsListControl($this->donor, $this->station);
    }

    public function renderDetail($id)
    {
        $defaults = $this->donor->findOneBy(array('id' => $id));
        $this['detail']->defaults = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new Form($this, $name);
        $form->addText('id', 'ID:')
            ->setRequired()
            ->setAttribute('readonly');
        $form->addText('nick', 'Nick:')
            ->setRequired()
            ->setAttribute('readonly');
        $form->addText('name', 'Name:'
        )->setRequired();
        $form->addText('surname', 'Surname:')
            ->setRequired();
        $form->addText('postal_code', 'Postal code:');
        $form->addText('city', 'City:');
        $form->addText('street', 'Street:');
        $form->addText('phone', 'Phone:');
        $form->addText('email', 'Email:');
        $form->addText('blood_type', 'Blood type:'
        )->setRequired();
        $form->addText('national_id', 'National ID:')
            ->setRequired();
        $form->addRadioList('active', 'Active:', array(0 => 'inactive', 1 => 'active'))
            ->setRequired();
        $stationNames = $this->station->getStationNames();
        $form->addSelect('pref_station', 'Preferred station:', $stationNames);
        $form->addTextArea('note', 'Note:');
        $form->addSubmit('edit', 'Edit');
        $form->onSuccess[] = callback($this, 'detailEdited');
        if (isset($form->defaults))
            $form->setDefaults($form->defaults);
        return $form;
    }

    public function detailEdited(Form $form)
    {
        $values = $form->getValues();
        $this->donor->update($values, $values['id']);
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['nick'] . ') was edited.');
    }
    
    public function renderInvitation($donorid)
    {
        $this->template->invitations = $this->invitation->findBy(array('donor'=>$donorid));
    }
}

