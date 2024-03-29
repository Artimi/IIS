<?php

namespace NurseModule;

/**
 * Description of DonorPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz> */
class DonorsPresenter extends \NurseModule\BasePresenter
{

    private $donor;
    private $station;
    private $invitation;
    private $drawn;
    private $defaultsDetail;
    private $data = array();
    private $stationNames;
    protected $columns = array('id', 'name', 'surname', 'blood_type', 'active', 'pref_station');

    public function startup()
    {
        parent::startup();

        $this->donor = $this->context->donor;
        $this->station = $this->context->station;
        $this->invitation = $this->context->invitation;
        $this->drawn = $this->context->drawn;

        $this->data['stationNames'] = $this->station->getStationNames();
        $this->data['bloodTypes'] = $this->donor->bloodTypes;
        
        $this->stationNames = $this->station->getStationNames();
        $this->template->stationNames = $this->stationNames;
    }

    public function renderDefault()
    {
        $this->getDefaults();

    }

    public function renderDetail($id)
    {

        $defaults = $this->donor->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\DonorDetailForm($this->data, $this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'donorEdited');
        return $form;
    }

    public function donorEdited(\Nette\Application\UI\Form $form)
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
        $form = new \BloodCenter\DonorDetailForm($this->data);
        $form['submit']->caption = 'Add';
        unset($form['id']);
        $form->onSuccess[] = callback($this, 'addDonor');
        return $form;
    }

    public function addDonor(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['id'] = $this->donor->generateNick($values['surname']);
        try
        {
            $this->donor->insert($values);
        }
        catch(\PDOException $e)
        {
            if($e->getCode()==23000)
            {
                $this->flashMessage('There already is donor with this national id!');
                return;
            }
        }
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
        return new \BloodCenter\DonorGrid($this->donor, $this->stationNames, $this->default);
    }

}

