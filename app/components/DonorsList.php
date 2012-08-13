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
    private $selected;

    public function __construct(Nette\Database\Table\Selection $selected)
    {
        parent::__construct(); 
        $this->selected = $selected;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/DonorsList.latte');
        $this->template->donors = $this->selected;
        $this->template->render();
    }
}

