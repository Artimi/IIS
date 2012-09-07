<?php

/**
 * Description of DonorList
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */

namespace BloodCenter;

use Nette;
use Nette\Diagnostics\Debugger;

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
        $this->addComponent(new \Detail($defaults), 'detail');
    }

}

