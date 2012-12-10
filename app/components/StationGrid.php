<?php

namespace BloodCenter;

/**
 * Description of StationGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class StationGrid extends \NiftyGrid\Grid
{

    protected $station;
    protected $default;

    public function __construct($station, $default = array())
    {
        parent::__construct();
        $this->station = $station;
        $this->default = $default;
        $this->setFilter($default);
    }

    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->station->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
            ->setNumericFilter();
        $this->addColumn('name', 'Name')
              ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['name'])
                ->href($presenter->link("Station:detail", $row['id']));})
            ->setTextFilter();
        $this->addColumn('postal_code', 'Postal Code')
            ->setDateFilter();
        $this->addColumn('city', 'City')
            ->setTextFilter();
        $this->addColumn('street', 'Street')
            ->setTextFilter();
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Station:detail", $row['id']);})
            ->setAjax(FALSE);
        $this->addGlobalButton('add_station', 'Add station')
            ->setLink($presenter->link('Station:addStation'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
    }

}
