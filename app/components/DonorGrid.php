<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BloodCenter; 
/**
 * Description of DonorGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DonorGrid extends \NiftyGrid\Grid
{
    protected $donor;
    protected $default;
    private $stationNames;
    
    public function __construct($donor, $stationNames, $default = array())
    {
        parent::__construct();
        $this->donor = $donor;
        $this->default = $default;
        $this->stationNames = $stationNames;
        $this->setFilter($default);
    }
    
    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->donor->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
              ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['id'])
                ->href($presenter->link("Donors:detail", $row['id']));})
            ->setTextFilter();
        $this->addColumn('name', 'Name')
            ->setTextFilter();
        $this->addColumn('surname', 'Surname')
            ->setTextFilter();
        $this->addColumn('blood_type', 'Blood type')
            ->setSelectFilter($this->donor->bloodTypes);
        $active = array(0 => 'inactive', 1 => 'active');
        $this->addColumn('active', 'Active')
            ->setRenderer(function($row) use($active) {return $active[$row['active']];})
            ->setBooleanFilter($active);
        $stationNames = $this->stationNames;
        $this->addColumn('pref_station', 'Preferred station')
            ->setRenderer(function($row) use ($presenter, $stationNames)
                {return \Nette\Utils\Html::el('a')
                ->setText($stationNames[$row['pref_station']])
                ->href($presenter->link("Station:detail", $row['id']));})
            ->setSelectFilter($stationNames);
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Donors:detail", $row['id']);})
            ->setAjax(FALSE);
    }
}
