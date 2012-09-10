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
    private $drawn;
    private $defaultsDetail;
    private $defaultAddInvitaion;
    private $defaultAddDrawn;
    private $stationNames;

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
        $this->drawn = $this->context->drawn;

        $this->stationNames = $this->station->getStationNames();
        $this->template->stationNames = $this->stationNames;
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
        if ($this->getUser()->isInRole('nurse'))
        {
            return new BloodCenter\DonorsListControl($this->donor);
        }
        else
        {
            return new BloodCenter\DonorsListControl($this->donor, $this->getUser()->id);
        }
    }

    public function renderDetail($id)
    {
        $defaults = $this->donor->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new BloodCenter\DetailForm($this->defaultsDetail, $this->stationNames);
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

    public function renderAddDonor()
    {
        
    }

    public function createComponentAddDonor($name)
    {
        $form = new BloodCenter\DetailForm(NULL, $this->stationNames);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addDonor');
        return $form;
    }

    public function addDonor(Form $form)
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
        $this->template->donorid = $donorid;
    }

    public function renderDrawn($donorid)
    {
        $this->template->drawns = $this->drawn->findBy(array('donor' => $donorid));
        $this->template->donorid = $donorid;
    }

    public function renderAddInvitation($donorid)
    {
        $this->defaultAddInvitaion = array('donor' => $donorid);
    }

    public function createComponentAddInvitation($name)
    {
        $form = new BloodCenter\InvitationForm($this->defaultAddInvitaion, $this->stationNames);
        $form->onSuccess[] = callback($this, 'addInvitation');
        return $form;
    }

    public function addInvitation(Form $form)
    {
        $values = $form->getValues();
        $this->invitation->insert($values);
        $this->flashMessage('Added invitation for donor ' . $values['donor']);
    }

    public function renderAddDrawn($donorid)
    {
        $this->defaultAddDrawn = array('donor' => $donorid,
                                       'date' => date('Y-m-d H-i-s'),
                                        'nurse' => $this->getUser()->id);
    }

    public function createComponentAddDrawn($name)
    {
        $form = new BloodCenter\DrawnForm($this->defaultAddDrawn, $this->stationNames);
        $form->onSuccess[] = callback($this, 'addDrawn');
        return $form;
    }

    public function addDrawn(Form $form)
    {
        $values = $form->getValues();
        if ($values['reservation'] == '') //TODO little hack to avoid foreign_key error
            $values['reservation'] = NULL;
        $this->drawn->insert($values);
        $this->flashMessage('Added drawn of donor ' . $values['donor']);
    }

}

