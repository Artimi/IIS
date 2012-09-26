<?php


namespace BloodCenter;

/**
 * Description of NurseDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class NurseDetailForm extends \Nette\Application\UI\Form
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
        $this->addText('postal_code', 'Postal code:');
        $this->addText('city', 'City:');
        $this->addText('street', 'Street:');
        $this->addText('phone', 'Phone:');
        $this->addText('national_id', 'National ID:')
            ->setRequired();
        $this->addSelect('station', 'Station:', $data['stationNames']);
        $this->addSubmit('submit', 'Submit:');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }

}
