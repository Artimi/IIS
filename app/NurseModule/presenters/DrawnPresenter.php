<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace NurseModule;
/**
 * Description of DrawnPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnPresenter extends \NurseModule\BasePresenter
{

    private $drawn;
    private $defaultAddDrawn;
    protected $columns = array('id', 'date', 'donor', 'blood_type', 'nurse', 'store', 'reservation', 'quality');

    public function startup()
    {
        parent::startup();
        if(!$this->user->isLoggedIn()  or !$this->user->isInRole('nurse'))
        {
            $this->flashMessage('You have to be signed in as a nurse.');
            $this->redirect(':Sign:in');
        }

        $this->drawn = $this->context->drawn;
    }

    public function renderDefault()
    {
        $this->getDefaults();
    }

    public function createComponentDrawnGrid()
    {
        return new \BloodCenter\DrawnGrid($this->drawn, $this->default);
    }

    public function renderAddDrawn($donor)
    {
        $this->defaultAddDrawn = array('donor' => $donor,
            'date' => date('Y-m-d H-i-s'),
            'nurse' => $this->getUser()->id);
    }

    public function createComponentAddDrawn($name)
    {
        $form = new \BloodCenter\DrawnForm($this->defaultAddDrawn);
        $form->onSuccess[] = callback($this, 'addDrawn');
        return $form;
    }

    public function addDrawn(Form $form)
    {
        $values = $form->getValues();
        if ($values['reservation'] == '') //TODO little hack to avoid foreign_key error
            $values['reservation'] = NULL;
        $this->drawn->insert($values);
        $this->flashMessage('Added drawn of donor ' . $values['donor']);
    }

}
