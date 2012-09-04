<?php
//use \Nette\Forms\Form,
use Nette\Application\UI\Form;
use    Nette\Security as NS;
use Nette\Diagnostics\Debugger;
use Nette\Forms\Controls\SubmitButton;
/**
 * Sign in/out presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class SignPresenter extends BasePresenter
{

    
    /**
     * Sign in form component factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm($name)
    {

        $form = new Form($this,$name);
        $form->addText('username', 'Username:')
            ->setRequired('Please provide a username.');
        $form->addPassword('password', 'Password:')
            ->setRequired('Please provide a password.');
        $form->addCheckbox('remember', 'Remember me on this computer');

        $form->addSubmit('send', 'Sign in');//->onClick[] =callback($this, 'signInFormSubmitted');
//        $form->onSuccess[] = $this->signInFormSubmitted;
        $form->onSuccess[] = callback($this,'signInFormSubmitted');
        return $form;
    }

    public function signInFormSubmitted(Form $form)
    {
        Debugger::log("Sign In form submitted");
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
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Homepage:');
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
