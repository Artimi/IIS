<?php

namespace BloodCenter; 

/**
 * Description of NurseGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 * @author Martin Šimon <xsimon14@stud.fit.vutbr.cz>
 * @author Jakub Šimon <xsimon06@stud.fit.vutbr.cz>
 */
class NurseGrid extends \NiftyGrid\Grid
{
    protected $nurse;
    protected $default;
    private $stationNames;
    
    public function __construct($nurse, $stationNames, $default = array())
    {
        parent::__construct();
        $this->nurse = $nurse;
        $this->default = $default;
        $this->stationNames = $stationNames;
        $this->setFilter($default);
    }
    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->nurse->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
              ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['id'])
                ->href($presenter->link("Nurse:detail", $row['id']));})
            ->setTextFilter();
        $this->addColumn('name', 'Name')
            ->setTextFilter();
        $this->addColumn('surname', 'Surname')
            ->setTextFilter();
        $stationNames = $this->stationNames;
        $this->addColumn('station', 'Station')
            ->setRenderer(function($row) use($stationNames, $presenter)
                {return \Nette\Utils\Html::el('a')
                    ->setText($stationNames[$row['station']])
                    ->href($presenter->link('Station:detail', $row['station']));})
            ->setSelectFilter($stationNames);
        $this->addColumn('phone', 'Phone')
            ->setTextFilter();
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Nurse:detail", $row['id']);})
            ->setAjax(FALSE);
        $this->addButton('drawn','Drawns')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Drawn:default", array('nurse' => $row['id']));})
            ->setAjax(FALSE);
        $this->addGlobalButton('add_nurse', 'Add nurse')
            ->setLink($presenter->link('Nurse:addNurse'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
        
    }
    
    
}
