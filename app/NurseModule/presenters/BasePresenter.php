<?php

namespace NurseModule;

/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    protected $default;
    protected $columns = array();
    protected function createComponentNavigation($name)
    {
        $nav = new \Navigation\Navigation($this, $name);
        $nav->setupHomepage("Donor", $this->link("Donor:"));
        $drawn = $nav->add("Drawn", $this->link("Drawn:"));
        $invitation = $nav->add("Invitation", $this->link("Invitation:"));
        $nurse = $nav->add("Nurse", $this->link("Nurse:"));
        $station = $nav->add("Station", $this->link("Station:"));
//		$personal = $nav->add("Person", $this->link("Person:"));
//		$reservation = $nav->add("Reservation", $this->link("Reservation:"));
//		$system = $nav->add("System", $this->link("System:"));
//		$nav->setCurrentNode($donor);
        // or $article->setCurrent(TRUE);
    }

    protected function getDefaults()
    {
        $query = $this->context->httpRequest->getQuery();
        $default = array();
        foreach ($query as $key => $value)
        {
            if (in_array($key, $this->columns))
                $default[$key] = $value;
        }
        $this->default = $default;
    }

}
