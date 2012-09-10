<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BloodCenter;
use Nette\Application\UI\Form;
/**
 * Description of DrawnForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnForm extends Form
{

    public function __construct($defaults, $stationNames, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('date', 'Date:')//TODO better date picking
            ->setRequired();
        $this->addText('donor', 'Donor:')
            ->setRequired();
        $this->addText('blood_type', 'Blood type:'); 
        $this->addText('nurse', 'Nurse:')
            ->setRequired();
        $this->addSelect('store', 'Store:', $stationNames)
            ->setRequired();
        $this->addText('reservation', 'Reservation:');
        $this->addText('quality', 'Quality:');
        $this->addSubmit('submit','Submit');
        if ($defaults != NULL)
        {
            $this->setDefaults($defaults);
        }
    }

}