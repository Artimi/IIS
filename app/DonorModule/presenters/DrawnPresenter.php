<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace DonorModule;
/**
 * Description of DrawnPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DrawnPresenter extends \DonorModule\BasePresenter
{

    private $drawn;
    private $default;
    private $defaultAddDrawn;
    private $columns = array('id', 'date', 'donor', 'blood_type', 'nurse', 'store', 'reservation', 'quality');

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

    public function renderDefault()
    {
        $query = $this->context->httpRequest->getQuery();
        $default = array();
        foreach($query as $key => $value)
        {
            if (in_array($key, $this->columns))
                $default[$key] = $value;
        }
        $this->default = $default;
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
