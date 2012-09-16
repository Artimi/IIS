<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DrawnPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnPresenter extends BasePresenter
{

    private $drawn;
    private $default;
    private $defaultAddDrawn;

    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect('Sign:in');
        }

        $this->drawn = $this->context->drawn;
    }

    public function renderDefault($default=NULL)
    {
        if ($default != NULL)
            $this->default = array('donor' => $default); //TODO pass array not string
        else
            $this->default = array();
    }

    public function createComponentDrawnGrid()
    {
        return new BloodCenter\DrawnGrid($this->drawn, $this->default);
    }

    public function renderAddDrawn($donor)
    {
        $this->defaultAddDrawn = array('donor' => $donor,
            'date' => date('Y-m-d H-i-s'),
            'nurse' => $this->getUser()->id);
    }

    public function createComponentAddDrawn($name)
    {
        $form = new BloodCenter\DrawnForm($this->defaultAddDrawn);
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
