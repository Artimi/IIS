<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BloodCenter;
use Nette\Application\UI\Form;

/**
 * Description of InvitationForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class InvitationForm extends Form
{

    public function __construct($defaults, $stationNames, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('donor', 'Donor:')
            ->setRequired();
        $this->addText('date', 'Date:'); //TODO better date picking
        $this->addSelect('station', 'Station:', $stationNames)
            ->setRequired();
        $this->addSelect('type', 'Type:', array('normal' => 'normal', 'urgent' => 'urgent'));
        $this->addSubmit('submit','Submit');
        if ($defaults != NULL)
        {
            $this->setDefaults($defaults);
        }
    }

}