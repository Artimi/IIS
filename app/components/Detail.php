<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BloodCenter;

/**
 * Description of Detail
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class Detail extends \Nette\Application\UI\Form
{
    public function __construct($defaults, $stationNames, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('nick', 'Nick:')
            ->setAttribute('readonly');
        $this->addText('name', 'Name:'
        )->setRequired();
        $this->addText('surname', 'Surname:')
            ->setRequired();
        $this->addText('postal_code', 'Postal code:');
        $this->addText('city', 'City:');
        $this->addText('street', 'Street:');
        $this->addText('phone', 'Phone:');
        $this->addText('email', 'Email:');
        $this->addText('blood_type', 'Blood type:'
        )->setRequired();
        $this->addText('national_id', 'National ID:')
            ->setRequired();
        $this->addRadioList('active', 'Active:', array(0 => 'inactive', 1 => 'active'))
            ->setRequired();
//        $stationNames = $this->station->getStationNames();
        $this->addSelect('pref_station', 'Preferred station:', $stationNames);
        $this->addTextArea('note', 'Note:');
        $this->addSubmit('submit', 'Submit:');
//        $this->onSuccess[] = callback($this, 'detailEdited');
        if (isset($defaults))
            $this->setDefaults($defaults);
//        return $this;
    }

}
