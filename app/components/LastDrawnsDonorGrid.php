<?php

namespace BloodCenter; 
/**
 * Description of LastDrawnsDonorGrid 
 *
 */
class LastDrawnsDonorGrid extends \NiftyGrid\Grid
{
    //protected $donor;
    protected $default;
    protected $drawn;
    
    public function __construct($drawn,$default = array())
    {
        parent::__construct();
        $this->drawn = $drawn;
        $this->default = $default;
        //$this->setFilter($default);
    }
    
    protected function configure($presenter)
    {
        //$this->drawn = $presenter->context->drawn;
        $source = new \NiftyGrid\NDataSource($this->drawn->findBy(array('donor' => $presenter->user->getIdentity()->id)));
        $this->setDataSource($source);
        $this->enableSorting = FALSE;
        $this->paginate = FALSE;

        $this->addColumn('date','Date');
        $this->addColumn('nurse','Nurse');
        $this->addColumn('store','Stored');
        $this->addColumn('quality','Quality');
        /*
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
              ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['id'])
                ->href($presenter->link("Donor:detail", $row['id']));})
            ->setTextFilter();
        $this->addColumn('name', 'Name')
            ->setTextFilter();
        $this->addColumn('surname', 'Surname')
            ->setTextFilter();
        $this->addColumn('blood_type', 'Blood type')
            ->setSelectFilter($this->donor->bloodTypes);
        $this->addColumn('active', 'Active')
            ->setBooleanFilter(array(0 => 'inactive', 1 => 'active'));
        $this->addColumn('pref_station', 'Preferred station')
            ->setTextFilter(); //TODO select filter
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Donor:detail", $row['id']);})
            ->setAjax(FALSE);
        $this->addButton('invitation','Invitations')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Invitation:default", array('donor' => $row['id']));})
            ->setAjax(FALSE);
        $this->addButton('drawn','Drawns')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Drawn:default", array('donor' => $row['id']));})
            ->setAjax(FALSE);
        $this->addGlobalButton('add_donor', 'Add donor')
            ->setLink($presenter->link('Donor:addDonor'))
            ->setClass('ym-button')
            ->setAjax(FALSE);*/
    }
}
