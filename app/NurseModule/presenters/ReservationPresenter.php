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
    private $defaultsDetail;   
    
    protected $columns = array('id', 'order_from', 'blood_type', 'quantity', 'date', 'note', 'state');

    
    
    protected function startup()
    {
        parent::startup();
        
        $this->reservation = $this->context->reservation;
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
        $form = new \BloodCenter\ReservationDetailForm(NULL, $this->reservation);
        $form['submit']->caption = 'Add';
        $form->onSuccess[] = callback($this, 'addStation');
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
        $form = new \BloodCenter\ReservationDetailForm($this->defaultsDetail,
                                                        $this->reservation);
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

}