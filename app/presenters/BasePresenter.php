<?php
use Navigation\Navigation;
/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

            protected function createComponentNavigation($name)
        {
		$nav = new Navigation($this, $name);
		$nav->setupHomepage("Home", $this->link("Homepage:"));
		$donor = $nav->add("Donor", $this->link("Donor:"));
		$drawn = $nav->add("Drawn", $this->link("Drawn:"));
//		$invitation = $nav->add("Invitation", $this->link("Invitation:"));
//		$personal = $nav->add("Person", $this->link("Person:"));
//		$reservation = $nav->add("Reservation", $this->link("Reservation:"));
//		$system = $nav->add("System", $this->link("System:"));
//		$nav->setCurrentNode($donor);
		// or $article->setCurrent(TRUE);
	}
}
