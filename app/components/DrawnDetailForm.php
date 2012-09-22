<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BloodCenter;
use Nette\Application\UI\Form;
/**
 * Description of DrawnDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnDetailForm extends Form
{

    public function __construct($defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID')
            ->setAttribute('readonly');
        $this->addText('date', 'Date:')//TODO better date picking
            ->setRequired();
        $this->addText('donor', 'Donor:')
            ->setRequired();
        $this->addText('blood_type', 'Blood type:'); 
        $this->addText('nurse', 'Nurse:')
            ->setRequired();
//        $this->addSelect('store', 'Store:', $stationNames)
//            ->setRequired();
        $this->addText('store', 'Store');
        $this->addText('reservation', 'Reservation:');
        $quality = array(0 => 'bad', 1 => 'good');
        $this->addSelect('quality', 'Quality:', $quality);
        $this->addSubmit('submit','Submit');
        if ($defaults != NULL)
        {
            $this->setDefaults($defaults);
        }
    }

}