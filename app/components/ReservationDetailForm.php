<?php


namespace BloodCenter;

/**
 * Description of ReservationDetailForm
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class ReservationDetailForm extends \Nette\Application\UI\Form
{
    public function __construct($defaults, $reservation, \Nette\ComponentModel\IContainer $parent = NULL, $name = NULL)
    {
        parent::__construct($parent, $name);
        $this->addText('id', 'ID:')
            ->setAttribute('readonly');
        $this->addText('order_from', 'Order_from:')
            ->setRequired();
        $this->addSelect('blood_type', 'Blood type:', $reservation->bloodTypes)
            ->setRequired();
        $this->addText('quantity', 'Quantity:')
            ->setRequired();
        $this->addText('date', 'Date:')
            ->setRequired();
        $this->addSelect('state', 'State:', $reservation->reservationState)
            ->setRequired();
        $this->addTextArea('note', 'Note:');
        $this->addSubmit('submit', 'Submit:');
        if ($defaults != NULL)
            $this->setDefaults($defaults);
    }

}
