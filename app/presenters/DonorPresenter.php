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

