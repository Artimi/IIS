<?php

use Nette\Application\UI\Form;
/**
 * Description of Detail
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class Detail extends Nette\Application\UI\Control
{
    private $defaults;
    
    public $submitted = array();
    
    
    public function __construct($defaults = null)
    {
        parent::__construct();

        if (isset($defaults))
            $this->defaults = $defaults;
        $this->submitted = callback($this, 'detailSubmitted');
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(dirname(__FILE__) . '/Detail.latte');
        $template->render();
    }

    public function createComponentDetail($name)
    {
        $form = new Form($this, $name);
        $form->addText('id', 'ID:')->setRequired()->setDisabled();
        $form->addText('nick', 'Nick:')->setRequired()->setDisabled();
        $form->addText('name', 'Name:')->setRequired();
        $form->addText('surname', 'Surname:')->setRequired();
        $form->addText('postal_code', 'Postal code:');
        $form->addText('city', 'City:');
        $form->addText('street', 'Street:');
        $form->addText('phone', 'Phone:');
        $form->addText('email', 'Email:');
        $form->addText('blood_type', 'Blood type:')->setRequired();
        $form->addText('national_id', 'National ID:')->setRequired();
        $form->addText('active', 'Preferred station:')->setRequired();
        $form->addTextArea('note', 'Note:');
        $form->addSubmit('edit', 'Edit');
        $form->onSuccess[] = callback($this, 'detailSubmitted');
        if (isset($this->defaults))
            $form->setDefaults($this->defaults);
//        $form->setAction($this->getPresenter()->link("Donor:", array("do" => "donorsList-detailsubmit")));
        return $form;
    }

    public function detailSubmitted(Form $form)
    {
        $values = $form->getValues();
//        foreach ($values as $value)
//        Nette\Diagnostics\Debugger::dump(array($values));
//        $this->donors->update($values);
    }

}
