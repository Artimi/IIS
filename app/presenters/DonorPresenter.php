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
    
    private $defaultsDetail;

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
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new BloodCenter\Detail($this->defaultsDetail, $this->station->getStationNames());
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'donorEdited');
        return $form;
    }

    public function donorEdited(Form $form)
    {
        $values = $form->getValues();
        $this->donor->update($values, $values['id']);
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['nick'] . ') was edited.');
    }
    
    public function renderAdd()
    {
        
    }
    
    public function createComponentAdd($name)
    {   
        $form = new BloodCenter\Detail($this->defaultsDetail, $this->station->getStationNames());
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'donorAdd');
        return $form;
    }
    
    public function donorAdd(Form $form)
    {
        $values = $form->getValues();
        $values['nick'] = $this->donor->createNick($values['surname']);
        $result = $this->donor->insert($values);
//        Nette\Diagnostics\Debugger::dump($result->id);
        //TODO password
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['nick'] . ') was added.');
    }

    public function renderInvitation($donorid)
    {
        $this->template->invitations = $this->invitation->findBy(array('donor' => $donorid));
    }

}

