<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BloodCenter; 
/**
 * Description of DrawnGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnGrid extends \NiftyGrid\Grid
{
    protected $drawn;
    protected $default;

    
    public function __construct($drawn, $default = array())
    {
        parent::__construct();
        $this->drawn = $drawn;
        $this->default = $default;
        $this->setFilter($default);
    }
    
    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->drawn->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
            ->setNumericFilter();
        $this->addColumn('date', 'Date')
            ->setDateFilter();
        $this->addColumn('donor', 'Donor')
            ->setTextFilter();
        $this->addColumn('blood_type', 'Blood type')
            ->setSelectFilter($this->drawn->bloodTypes);
        $this->addColumn('nurse', 'Nurse')
            ->setTextFilter();
        $this->addColumn('store', 'Store')
            ->setTextFilter();
        $this->addColumn('reservation', 'Reservation')
             ->setTextFilter();
        $this->addColumn('quality', 'Quality')
             ->setBooleanFilter(array(0 => 'bad', 1 => 'good'));
        $this->addGlobalButton('add_drawn', 'Add drawn')
            ->setLink($presenter->link('Drawn:addDrawn'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
        
    }
   
}
