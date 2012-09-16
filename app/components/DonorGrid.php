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
    
    public function __construct($donor,$default = array())
    {
        parent::__construct();
        $this->donor = $donor;
        $this->default = $default;
        foreach ($this->default as $column => $value)
        {
            $this->filter[$column] = $value;
        }
    }
    
    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->donor->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
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
            ->setLink(function($row) use ($presenter){return $presenter->link("Donor:invitation", $row['id']);})
            ->setAjax(FALSE);
        $this->addButton('drawn','Drawns')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Drawn:default", $row['id']);}) //TODO pass hash array not single string
            ->setAjax(FALSE);
        $this->addGlobalButton('add_donor', 'Add donor')
            ->setLink($presenter->link('Donor:addDonor'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
        
    }
    
    
}