<?php

/**
 * Description of DonorList
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */

namespace BloodCenter;

use Nette;
use Nette\Application\UI\Form;

class DonorsListControl extends Nette\Application\UI\Control
{

    /** @var \Nette\Database\Table\Selection */
    private $donors;

    public function __construct(\BloodCenter\Donor $donors)
    {
        parent::__construct();
        $this->donors = $donors;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/DonorsList.latte');
        $this['paginator']->paginator->itemCount = $this->donors->getCount();
        $this->template->donors = $this->donors
            ->findOffset($this['paginator']->paginator->offset, $this['paginator']->paginator->itemsPerPage);
        $this->template->render();
    }

    public function createComponentPaginator()
    {
        $vp = new \VisualPaginator();
        $vp->paginator->itemsPerPage = 4;
        return $vp;
    }

    public function handleDetail($id)
    {
        $defaults = $this->donors->findOneBy(array('id' => $id));
        $this['detail']->defaults = $defaults;
    }

    public function createComponentDetail($name)
    {
        $form = new Form($this, $name);
        $form->addText('id', 'ID:')->setRequired();
        $form->addText('nick', 'Nick:')->setRequired();
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
        $form->onSuccess[] = callback($this, 'detailEdited');
        if (isset($form->defaults))
            $form->setDefaults($form->defaults);
        return $form;
    }

    public function detailEdited(Form $form)
    {
        $values = $form->getValues();
        $this->donors->update($values, $values['id']);
        $this->flashMessage('Donor ' . $values['name'] . ' ' . $values['surname'] . ' (' . $values['nick'] . ') was edited.');
    }

}

