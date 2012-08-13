<?php

namespace BloodCenter;

use Nette;
use Nette\Security as NS;


/**
 * Users authenticator.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Authenticator extends Nette\Object implements NS\IAuthenticator
{
	/** @var Nette\Database\Table\Selection */
	private $database;
        private $donor;
        private $nurse;


	public function __construct(Nette\Database\Connection $database)
	{
	    $this->database = $database;
            $this->donor = $this->database->table('donor');
            $this->nurse = $this->database->table('nurse');
	}

	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
                if ($row = $this->donor->where('nick', $username)->fetch())
                {
                    $role = 'donor';
                }
                else if($row = $this->nurse->where('nick', $username)->fetch())
                {
                    $role = 'nurse';
                }
		else
                {
                    throw new NS\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}
		if ($row->password !== $this->calculateHash($password)) {
			throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		return new NS\Identity($row->id, $role, $row->toArray()); //TODO: same id different person, nurse id 1 != donor id 1
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
        public static function calculateHash($password, $salt = null)
        {
            return md5($password . str_repeat('*random salt*', 10));
        }
}

