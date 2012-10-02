<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace BloodCenter; 
/**
 * Description of InvitationGrid
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class InvitationGrid extends \NiftyGrid\Grid
{
    protected $invitation;
    protected $default;
    private $stationNames;
    
    public function __construct($invitation, $stationNames, $default = array())
    {
        parent::__construct();
        $this->invitation = $invitation;
        $this->default = $default;
        $this->stationNames = $stationNames;
        $this->setFilter($default);
    }
    
    protected function configure($presenter)
    {
        $source = new \NiftyGrid\NDataSource($this->invitation->findAll());
        $this->setDataSource($source);
        $this->setPerPageValues(array(10, 20, 50));
        $this->addColumn('id', 'ID')
            ->setNumericFilter();
        $this->addColumn('donor', 'Donor')
             ->setRenderer(function($row) use ($presenter)
                {return \Nette\Utils\Html::el('a')
                ->setText($row['donor'])
                ->href($presenter->link("Donors:detail", $row['donor']));})
            ->setTextFilter();
        $this->addColumn('date', 'Date')
            ->setDateFilter();
        $stationNames = $this->stationNames;
        $this->addColumn('station', 'Station')
            ->setRenderer(function($row) use($stationNames, $presenter)
                {return \Nette\Utils\Html::el('a')
                    ->setText($stationNames[$row['station']])
                    ->href($presenter->link('Station:detail', $row['station']));})
            ->setSelectFilter($stationNames);
        $this->addColumn('type', 'Type')
            ->setSelectFilter(array('normal' => 'normal', 'urgent' => 'urgent'));
        $invitationState = $this->invitation->invitationState;
        $this->addColumn('state','State')
            ->setSelectFilter($invitationState)
            ->setRenderer(function($row) use($invitationState) {return $invitationState[$row['state']];});
        $this->addButton('detail','Detail')
            ->setClass('ym-button')
            ->setLink(function($row) use ($presenter){return $presenter->link("Invitation:detail",  $row['id']);})
            ->setAjax(FALSE); 
        $this->addGlobalButton('add_invitation', 'Add invitation')
            ->setLink($presenter->link('Invitation:addInvitation'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
        
    }
    
    
}
