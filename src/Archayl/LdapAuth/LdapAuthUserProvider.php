<?php namespace Archayl\LdapAuth;

use Illuminate\Config\Repository;
use Illuminate\Auth;
use Zend\Ldap\Ldap;

/**
 * UserProviderInterface, to comply with Laravel 4 way
 * of authentication service provider
 */
class LdapAuthUserProvider implements Auth\UserProviderInterface
{
	/**
	 * Constructor
	 *
	 * @param $app
	 */
	public function __construct($app)
	{
		/** Hold app object */
		$this->app = $app;
		
		/** Hold ldap configuration */
		$this->ldconfig = $this->app['config']['ldap']['connection'];

		/** Instantiate a new Zend Ldap object */
		$this->ld = new \Zend\Ldap\Ldap($this->ldconfig);

		/** Get customized user settings */
		$this->settings = $this->app['config']['ldap']['settings'];

		/** 
		 * Determine server type
		 * 1 - ?
		 * 2 - OpenLdap
		 */
		$this->serverType = $this->ld->getRootDse()->getServerType();
	}

	/**
	 * Retrieve user by ID
	 *
	 * @param mixed $identifier
	 *
	 * @return Illuminate\Auth\GenericUser|null
	 */
	public function retrieveByID($identifier)
	{
		$filter = $this->settings['userFilter'].'='.$identifier;

		$data = $this->ld->search($filter)->getFirst();

		if(!count($data))
			return NULL;

		$attributes = $this->setInfoArray($data);

		return new LdapUser($attributes);
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
		$filter = $this->settings['userFilter'].'='.$credentials['username'];

		$data = $this->ld->search($filter)->getFirst();

		if(!count($data))
			return NULL;

		$attributes = $this->setInfoArray($data);

		return new LdapUser($attributes);
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
		$attributes = new \Zend\Ldap\Attribute();
		$password = $attributes->createPassword($credentials['password'],\Zend\Ldap\Attribute::PASSWORD_HASH_SHA);
		return $password == $user->getAuthPassword();
	}

	/**
	 * Data mapping
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function setInfoArray($data)
	{
		$attributes['id'] = $data[$this->settings['userFilter']][0];
		$attributes['password'] = $data['userpassword'][0];

		return $attributes;
	}
}
