<?php
namespace NurseModule;
/**
 * Description of ReservationPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class ReservationPresenter extends BasePresenter
{
    private $reservation;
    private $drawn;
    private $defaultsDetail;   
    
    protected $columns = array('id', 'order_from', 'blood_type', 'quantity', 'date', 'note', 'state');

    
    
    protected function startup()
    {
        parent::startup();
        
        $this->reservation = $this->context->reservation;
        $this->drawn = $this->context->drawn;
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }
    
    public function createComponentReservationGrid($name)
    {
        return new \BloodCenter\ReservationGrid($this->reservation);
    }
    
        public function createComponentAddReservation($name)
    {
        $form = new \BloodCenter\ReservationDetailForm($this->reservation);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addStation');
        $form['id']->setDisabled();
        return $form;
    }

    public function addReservation(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->reservation->insert($values);
        $this->flashMessage('Reservation ' . $values['name']. ' was added.');
    }
    
     public function renderDetail($id)
    {

        $defaults = $this->reservation->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\ReservationDetailForm($this->reservation, $this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'reservationEdited');
        return $form;
    }

    public function reservationEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $this->reservation->update($values, $values['id']);
        $this->flashMessage('Reservation ' . $values['id'] . ' was edited.');
    }
    
    public function handleSend($reservationId)
    {
        $toSend = $this->drawn->findBy(array('reservation' => $reservationId));
        $reservation = $this->reservation->find($reservationId);
        if ($toSend->count() < $reservation['quantity'])
        {
            $this->flashMessage('Reservation send could not be established because there are not enough drawns assigned to reservation '.$reservationId);
        }
        else
        {
            $counter = 0;
            foreach ($toSend as $drawn)
            {
                $counter++;
                if ($counter <= $reservation['quantity'])
                    $this->drawn->update(array('store' => NULL),$drawn['id']);
                else
                    $this->drawn->update(array('reservation' => NULL), $drawn['id']);
            }
            $this->reservation->update(array('state' => 1), $reservationId);
            $this->flashMessage('Reserved drawns was released from system.');
        }
            
    }

}