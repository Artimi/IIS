<?php

/**
 * Description of DonorPresenter
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */
class DonorPresenter extends BasePresenter
{

    private $donor;

    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect('Sign:in');
        }

        $this->donor = $this->context->donor;
    }

    public function renderDefault()
    {
        
    }

    public function createComponentDonorsList()
    {
        if (!$this->getUser()->isLoggedIn())
        {
            $this->flashMessage('You have to be signed in.');
            $this->redirect('Sign:in');
        }
        return new BloodCenter\DonorsListControl($this->donor);
    }

}

