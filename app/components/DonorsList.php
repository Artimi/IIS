<?php

/**
 * Description of DonorList
 *
 * @author Petr Šebek <xsebek02@stud.fit.vutbr.cz>
 */

namespace BloodCenter;

use Nette;

class DonorsListControl extends Nette\Application\UI\Control
{

    /** @var \Nette\Database\Table\Selection */
    private $donor;
    private $station;

    public function __construct(\BloodCenter\Donor $donor,
                                \BloodCenter\Station $station)
    {
        parent::__construct();
        $this->donor = $donor;
        $this->station = $station;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/DonorsList.latte');
        $this['paginator']->paginator->itemCount = $this->donor->getCount();
        $this->template->donors = $this->donor
            ->findOffset($this['paginator']->paginator->offset, $this['paginator']->paginator->itemsPerPage);
        $this->template->render();
    }

    public function createComponentPaginator()
    {
        $vp = new \VisualPaginator();
        $vp->paginator->itemsPerPage = 4;
        return $vp;
    }
}

