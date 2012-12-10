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

    public function __construct($data,$defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID')
            ->setAttribute('readonly');
        $this->addText('date', 'Date:')//TODO better date picking
            ->setRequired()
            ->setOption('description','YYYY-MM-DD HH-MM-SS');
        $this->addSelect('donor', 'Donor:', $data['donors'])
            ->setRequired();
        $this->addSelect('blood_type', 'Blood type:', $data['bloodTypes']);//FIXME!!! musi byt podle darce!!!!!
        $this->addSelect('nurse', 'Nurse:',$data['nurses'])
            ->setRequired();
        $this->addSelect('store', 'Store', $data['stationNames']);
        $this->addSelect('reservation', 'Reservation:', $data['reservation']);
        $quality = array(1 => 'good', 0 => 'bad');
        $this->addSelect('quality', 'Quality:', $quality);
        $this->addSubmit('submit','Submit')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
        {
            $this->setDefaults($defaults);
        }
    }

}