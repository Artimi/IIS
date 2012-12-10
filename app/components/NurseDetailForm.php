<?php

namespace BloodCenter;
use \Nette\Application\UI\Form;

/**
 * Description of NurseDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class NurseDetailForm extends Form
{
    public function __construct($data, $defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('name', 'Name:'
        )->setRequired();
        $this->addText('surname', 'Surname:')
            ->setRequired();
        $this->addText('postal_code', 'Postal code:')
            ->addCondition(Form::FILLED)
            ->addRule(Form::INTEGER, 'Postal code must be integer.')
            ->addRule(Form::LENGTH, 'Postal code must be 5 chars long.', 5);
        $this->addText('city', 'City:');
        $this->addText('street', 'Street:');
        $this->addText('phone', 'Phone:');
        $this->addText('national_id', 'National ID:')
            ->addRule(Form::INTEGER, 'National ID must be integer')
            ->addRule(Form::LENGTH, 'National ID must be 10 chars long',10)
            ->setRequired();
        $this->addSelect('station', 'Station:', $data['stationNames']);
        $this->addSubmit('submit', 'Submit:')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }

}
