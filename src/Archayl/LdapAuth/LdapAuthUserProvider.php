<?php namespace Archayl\LdapAuth;

use Illuminate\Config\Repository;
use Illuminate\Auth;
use Zend\Ldap\Ldap;

class LdapAuthUserProvider implements Auth\UserProviderInterface
{
	/** For config */
	private $config;
	
	/** For ldap object */
	private $ld;

	/** For app object */
	private $app;

	/** For ldap options*/
	private $options;

	/**
	 * Constructor
	 *
	 * @param $app
	 */
	public function __construct($app)
	{
		$this->app = $app;
		$this->config = $app['config'];
		$this->options = $app['config']['ldap'];
		$this->ld = new \Zend\Ldap\Ldap($options);
	}

	/**
	 * Retrieve user by ID
	 *
	 * @param mixed $identifier
	 *
	 * @return Illuminate\Auth\GenericUser|null
	 */
	public function retrieveByID($idenfitier)
	{
		// @todo
	}

	/**
	 * Retrieve user by credentials
	 *
	 * @param array $credentials
	 *
	 * @return Illuminate\Auth\GenericUser|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		dd($this->ld->exists($credentials['username']));
	}

	/**
	 * Validate user against credentials.
	 *
	 * @param Illuminate\Auth\UserInterface $user
	 * @param array $credentials
	 *
	 * @return bool
	 */
	public function validateCredentials(Auth\UserInterface $user, array $credentials)
	{
		// @todo
	}
}
