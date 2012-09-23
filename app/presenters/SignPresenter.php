<?php
use Nette\Application\UI\Form;
use Nette\Security as NS;

/**
 * Sign in/out presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class SignPresenter extends Nette\Application\UI\Presenter
{

    /**
     * Sign in form component factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm($name)
    {

        $form = new Form($this, $name);
        $form->addText('username', 'Username:')
            ->setRequired('Please provide a username.');
        $form->addPassword('password', 'Password:')
            ->setRequired('Please provide a password.');
        $form->addCheckbox('remember', 'Remember me on this computer');
        $form->addSubmit('send', 'Sign in');
        $form->onSuccess[] = callback($this, 'signInFormSubmitted');
        return $form;
    }

    public function signInFormSubmitted(Form $form)
    {
        try
        {
            $values = $form->getValues();
            if ($values->remember)
            {
                $this->getUser()->setExpiration('+ 14 days', FALSE);
            }
            else
            {
                $this->getUser()->setExpiration('+ 20 minutes', TRUE);
            }
            $user = $this->getUser();
            $user->login($values->username, $values->password);
            if ($user->isInRole('nurse'))
            {
                $this->redirect(':Nurse:Donor:');
            }
            else
            {
                $this->flashMessage('Welcome back, '. $user->getIdentity()->name.'!');
                $this->redirect(':Donor:Donor:');
            }
        }
        catch (NS\AuthenticationException $e)
        {
            $form->addError($e->getMessage());
        }
    }

    public function actionOut()
    {
        $this->getUser()->logout(TRUE);
        $this->flashMessage('You have been signed out.');
        $this->redirect('in');
    }

}
