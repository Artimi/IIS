<?php

namespace BloodCenter; 
/**
 * Description of DrawnGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class DrawnGrid extends \NiftyGrid\Grid
{
    protected $drawn;
    protected $default;
    private $stationNames;

    
    public function __construct($drawn, $stationNames, $default = array())
    {
        parent::__construct();
        $this->drawn = $drawn;
        $this->default = $default;
        $this->stationNames = $stationNames;
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
             ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['donor'])
                ->href($presenter->link("Donors:detail", $row['donor']));})
            ->setTextFilter();
        $this->addColumn('blood_type', 'Blood type')
            ->setSelectFilter($this->drawn->bloodTypes);
        $this->addColumn('nurse', 'Nurse')
            ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['nurse'])
                ->href($presenter->link("Nurse:detail", $row['nurse']));})
            ->setTextFilter();
        $stationNames = $this->stationNames;
        $this->addColumn('store', 'Store')
            ->setRenderer(function($row) use($stationNames, $presenter)
                {return \Nette\Utils\Html::el('a')
                    ->setText($stationNames[$row['store']])
                    ->href($presenter->link('Station:detail', $row['store']));})
            ->setSelectFilter($stationNames);
        $this->addColumn('reservation', 'Reservation')
             ->setRenderer(function($row) use($presenter)
                {return \Nette\Utils\Html::el('a')
                    ->setText($row['reservation'])
                    ->href($presenter->link('Reservation:detail', $row['reservation']));})
             ->setTextFilter();
        $quality = array(0 => 'bad', 1 => 'good');
        $this->addColumn('quality', 'Quality')
             ->setBooleanFilter($quality)
             ->setRenderer(function($row) use ($quality) {return $quality[$row['quality']];});
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Drawn:detail",  $row['id']);})
            ->setAjax(FALSE);                 
        $this->addGlobalButton('add_drawn', 'Add drawn')
            ->setLink($presenter->link('Drawn:addDrawn'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
//        $this->addAction('reserve', 'Reserve')
//            ->setCallback(function($id) use ($presenter){return $presenter->reserve($id);});
            
        
    }
   
}
