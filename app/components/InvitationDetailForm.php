<?php

namespace BloodCenter;
use Nette\Application\UI\Form;

/**
 * Description of InvitationForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class InvitationDetailForm extends Form
{

    public function __construct($data, $defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID')
            ->setAttribute('readonly');
        $this->addSelect('donor', 'Donor:', $data['donor'])
            ->setRequired();
        $this->addText('date', 'Date:')
            ->setOption('description','YYYY-MM-DD HH-MM-SS')
            ->setRequired();
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
