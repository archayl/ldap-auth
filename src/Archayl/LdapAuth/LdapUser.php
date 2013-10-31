<?php namespace Archayl\LdapAuth;

use Illuminate\Auth;

/**
 * This class arrange users according to the Laravel
 * requirements
 */
class LdapUser implements Auth\UserInterface
{
	/**
	 * User attributes
	 *
	 * @var array
	 */
	protected $attibutes;

	/**
	 * Get the attributes
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes)
	{
		$this->attributes = $attributes;
	}

	/**
	 * Get the unique identifier for the user
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->attributes['id'];
	}

	/**
	 * Get the password for the user
	 *
	 * @return mixed
	 */
	public function getAuthPassword()
	{
		return $this->attributes['password'];
	}
}
