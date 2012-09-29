<?php

namespace BloodCenter;

/**
 * Description of ReservationGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class ReservationGrid extends \NiftyGrid\Grid
{

    protected $reservation;
    protected $default;

    public function __construct($reservation, $default = array())
    {
        parent::__construct();
        $this->reservation = $reservation;
        $this->default = $default;
        $this->setFilter($default);
        
    }

    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->reservation->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
             ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['id'])
                ->href($presenter->link("Reservation:detail", $row['id']));})
            ->setNumericFilter();
        $this->addColumn('order_from', 'Order from')
            ->setTextFilter();
        $this->addColumn('blood_type', 'Blood type')
            ->setSelectFilter($this->reservation->bloodTypes);
        $this->addColumn('quantity', 'Quantity')
            ->setNumericFilter();
        $this->addColumn('date', 'Date')
            ->setTextFilter();
//        $this->addColumn('note', 'Note')
//            ->setTextFilter();
        $reservationState = $this->reservation->reservationState;
        $this->addColumn('state', 'State')
            ->setRenderer(function($row)  use ($reservationState) {return $reservationState[$row['state']];})
            ->setSelectFilter($this->reservation->reservationState);
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Reservation:detail", $row['id']);})
            ->setAjax(FALSE);
        $this->addButton('send','Send')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("send!", $row['id']);})
            ->setAjax(FALSE);
        $this->addGlobalButton('add_reservation', 'Add reservation')
            ->setLink($presenter->link('Reservation:addReservation'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
    }

}
