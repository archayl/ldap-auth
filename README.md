ldap-auth
=========

Auth service provider package for Laravel 4

# Installation

    composer require archayl\ldap-auth
    composer install

# Configuration

Add this line to the end of service provider array

    'Archayl\LdapAuth\LdapAuthServiceProvider',

Change `app\config\auth.php` driver to `ldap`

    'driver' => 'ldap',

Create `app\config\ldap.php` with this content:

    <?php

    return array(
		'connection' => array(
			'host' => 'dc.example.com',                    \\ your ldap server
			'username' => 'cn=admin,dc=example,dc=com',    \\ admin cn
			'password' => 'password',                      \\ admin password
			'baseDn' => 'ou=Users,dc=example,dc=com',      \\ user base dn
			'bindRequiresDn' => TRUE                       \\ mandatory for OpenLDAP
		),
		'settings' => array(
			'userFilter' => 'uid'                          \\ user filter, usually uid for OpenLDAP
		)
	);

# Usage

Use like usual Laravel authentication

# Caveat

Currently only tested with OpenLDAP because I dont have other LDAP Directory at disposal.

Thanks for being an exellent reference for this work:  
[ccovey/ldap-auth](https://github.com/ccovey/ldap-auth)  
[franzliedke/auth-fluxbb](https://github.com/franzliedke/auth-fluxbb)  
