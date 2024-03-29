<?php


namespace BloodCenter;
use \Nette\Application\UI\Form;
/**
 * Description of ReservationDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class ReservationDetailForm extends Form
{
    public function __construct($reservation, $defaults = NULL, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('order_from', 'Order from:')
            ->setOption('description', 'Name of external medical institution')
            ->setRequired();
        $this->addSelect('blood_type', 'Blood type:', $reservation->bloodTypes)
            ->setRequired();
        $this->addText('quantity', 'Quantity:')
            ->setOption('description', 'Count of units')
            ->setRequired()
            ->addRule(Form::INTEGER, 'Quantity must be integer.');
        $this->addText('date', 'Date:')
            ->setOption('description','YYYY-MM-DD HH-MM-SS')
            ->setRequired();
        $this->addSelect('state', 'State:', $reservation->reservationState)
            ->setRequired();
        $this->addTextArea('note', 'Note:');
        $this->addSubmit('submit', 'Submit:')
            ->setAttribute('class','ym-button');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }
}
