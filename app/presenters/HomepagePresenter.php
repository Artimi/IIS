<?php
/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */

use \Navigation;

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
}
