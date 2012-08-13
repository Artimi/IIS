<?php
/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */


class HomepagePresenter extends BasePresenter
{
    private $donor;

        public function startup()
        {
            parent::startup();
            $this->donor = $this->context->donor;
        }
    
	public function renderDefault()
	{

        }

        public function createComponentDonorsList()
        {
            return new BloodCenter\DonorsListControl($this->donor->findAll());
        }
}
