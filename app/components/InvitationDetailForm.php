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
class InvitationDetailForm extends Form
{

    public function __construct($data, $defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'Id')
            ->setAttribute('readonly');
        $this->addSelect('donor', 'Donor:', $data['donor'])
            ->setRequired();
        $this->addText('date', 'Date:')
            ->setRequired(); //TODO better date picking
        $this->addSelect('station', 'Station:', $data['stationNames'])
            ->setRequired();
        $this->addSelect('type', 'Type:', array('normal' => 'normal', 'urgent' => 'urgent'));
        $this->addSelect('state', 'State',$data['invitationState']);
        $this->addSubmit('submit','Submit')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
        {
            $this->setDefaults($defaults);
        }
    }

}
