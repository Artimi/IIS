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
    private $defaultsDetail;
    protected $columns = array('id', 'date', 'donor', 'blood_type', 'nurse', 'store', 'reservation', 'quality');

    public function startup()
    {
        parent::startup();

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
        $form = new \BloodCenter\DrawnDetailForm($this->defaultAddDrawn);
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

     public function renderDetail($id)
    {

        $defaults = $this->drawn->findOneBy(array('id' => $id));
        $this->defaultsDetail = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new \BloodCenter\DrawnDetailForm($this->defaultsDetail);
        $form['submit']->caption = 'Edit';
        $form->onSuccess[] = callback($this, 'drawnEdited');
        return $form;
    }

    public function drawnEdited(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        if ($values['reservation'] == '') //TODO little hack to avoid foreign_key error
            $values['reservation'] = NULL;
        $this->drawn->update($values, $values['id']);
        $this->flashMessage('Drawn '  . $values['id'] . ' was edited.');
    }
}
