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
    
    public function __construct($invitation,$default = array())
    {
        parent::__construct();
        $this->invitation = $invitation;
        $this->default = $default;
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
            ->setTextFilter();
        $this->addColumn('date', 'Date')
            ->setDateFilter();
        $this->addColumn('station', 'Station')
            ->setTextFilter();
        $this->addColumn('type', 'Type')
            ->setSelectFilter(array('normal' => 'normal', 'urgent' => 'urgent'));
        $invitationState = $this->invitation->invitationState;
        $this->addColumn('state','State')
            ->setSelectFilter($invitationState)
            ->setRenderer(function($row) use($invitationState) {return $invitationState[$row['state']];});
        $this->addGlobalButton('add_invitation', 'Add invitation')
            ->setLink($presenter->link('Invitation:addInvitation'))
            ->setClass('ym-button')
            ->setAjax(FALSE);
        
    }
    
    
}
