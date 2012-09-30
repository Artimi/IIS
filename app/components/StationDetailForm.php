<?php


namespace BloodCenter;

/**
 * Description of StationDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class StationDetailForm extends \Nette\Application\UI\Form
{
    public function __construct($defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('name', 'Name:')
            ->setRequired();
        $this->addText('postal_code', 'Postal code:')
            ->setRequired()
            ->addRule(Form::INTEGER, 'Postal code must be integer.')
            ->addRule(Form::LENGTH, 'Postal code must be 5 chars long.', 5);
        $this->addText('city', 'City:')
            ->setRequired();
        $this->addText('street', 'Street:')
            ->setRequired();
        $this->addSubmit('submit', 'Submit:')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }

}
