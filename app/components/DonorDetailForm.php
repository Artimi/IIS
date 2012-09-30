<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BloodCenter;

use \Nette\Application\UI\Form;
/**
 * Description of Detail
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DonorDetailForm extends Form
{
    public function __construct($data, $defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('name', 'Name:')
            ->setRequired();
        $this->addText('surname', 'Surname:')
            ->setRequired();
        $this->addText('postal_code', 'Postal code:')
            ->addRule(Form::INTEGER, 'Postal code must be integer.')
            ->addRule(Form::LENGTH, 'Postal code must be 5 chars long.', 5);
        $this->addText('city', 'City:');
        $this->addText('street', 'Street:');
        $this->addText('phone', 'Phone:');
        $this->addText('email', 'Email:')
            ->addRule(Form::EMAIL,'Email must be in email format: abc@def.gh.');
        $this->addSelect('blood_type', 'Blood type:', $data['bloodTypes'])
            ->setRequired();
        $this->addText('national_id', 'National ID:')
            ->setRequired()
            ->addRule(Form::INTEGER, 'National ID must be integer')
            ->addRule(Form::LENGTH, 'National ID must be 10 chars long',10);
        $this->addRadioList('active', 'Active:', array(0 => 'inactive', 1 => 'active'))
            ->setRequired();
        $this->addSelect('pref_station', 'Preferred station:', $data['stationNames']);
        $this->addTextArea('note', 'Note:');
        $this->addSubmit('submit', 'Submit:')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }

}
