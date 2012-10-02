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
    
    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn() or !$this->user->isInRole('nurse'))
        {
            $this->flashMessage('You have to be signed in as a nurse.');
            $this->redirect(':Sign:in');
        }
    }
    
    protected function createComponentNavigation($name)
    {
        $nav = new \Navigation\Navigation($this, $name);
        $nav->setupHomepage("Donor", $this->link("Donor:"));
        $drawn = $nav->add("Donors", $this->link("Donors:"));
        $drawn = $nav->add("Drawn", $this->link("Drawn:"));
        $invitation = $nav->add("Invitation", $this->link("Invitation:"));
        $nurse = $nav->add("Nurse", $this->link("Nurse:"));
        $station = $nav->add("Station", $this->link("Station:"));
        $reservation = $nav->add("Reservation", $this->link("Reservation:"));
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
