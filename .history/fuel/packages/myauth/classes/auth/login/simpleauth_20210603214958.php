<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

namespace MyAuth;

/**
 * SimpleAuth basic login driver
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Login_Simpleauth extends \Auth_Login_Driver
{
	/**
	 * Load the config and setup the remember-me session if needed
	 */
	// public static function _init()
	// {
	// 	\Config::load('simpleauth', true);

	// 	// setup the remember-me session object if needed
	// 	if (\Config::get('simpleauth.remember_me.enabled', false))
	// 	{
	// 		static::$remember_me = \Session::forge(array(
	// 			'driver' => 'cookie',
	// 			'cookie' => array(
	// 				'cookie_name' => \Config::get('simpleauth.remember_me.cookie_name', 'rmcookie'),
	// 			),
	// 			'encrypt_cookie' => true,
	// 			'expire_on_close' => false,
	// 			'expiration_time' => \Config::get('simpleauth.remember_me.expiration', 86400 * 31),
	// 		));
	// 	}
	// }

	/**
	 * @var  Database_Result  when login succeeded
	 */
	protected $user = null;

	/**
	 * @var  array  value for guest login
	 */
	protected static $guest_login = array(
		'id' => 0,
		'username' => 'guest',
		'group' => '0',
		'login_hash' => false,
		'email' => false,
	);

	/**
	 * @var  array  SimpleAuth class config
	 */
	protected $config = array(
		'drivers' => array('group' => array('Simplegroup')),
		'additional_fields' => array('profile_fields'),
	);

	/**
	 * Check for login
	 *
	 * @return  bool
	 */
	// protected function perform_check()
	// {
	// 	// fetch the username and login hash from the session
	// 	$username    = \Session::get('username');
	// 	$login_hash  = \Session::get('login_hash');

	// 	// only worth checking if there's both a username and login-hash
	// 	if ( ! empty($username) and ! empty($login_hash))
	// 	{
	// 		if (is_null($this->user) or ($this->user['username'] != $username and $this->user != static::$guest_login))
	// 		{
	// 			$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
	// 				->where('username', '=', $username)
	// 				->from(\Config::get('simpleauth.table_name'))
	// 				->execute(\Config::get('simpleauth.db_connection'))->current();
	// 		}

	// 		// return true when login was verified, and either the hash matches or multiple logins are allowed
	// 		if ($this->user and (\Config::get('simpleauth.multiple_logins', false) or $this->user['login_hash'] === $login_hash))
	// 		{
	// 			return true;
	// 		}
	// 	}

	// 	// not logged in, do we have remember-me active and a stored user_id?
	// 	elseif (static::$remember_me and $user_id = static::$remember_me->get('user_id', null))
	// 	{
	// 		return $this->force_login($user_id);
	// 	}

	// 	// no valid login when still here, ensure empty session and optionally set guest_login
	// 	$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
	// 	\Session::delete('username');
	// 	\Session::delete('login_hash');

	// 	return false;
	// }

	/**
	 * Check the user exists
	 *
	 * @return  bool
	 */
	// public function validate_user($username_or_email = '', $password = '')
	// {
	// 	$username_or_email = trim($username_or_email) ?: trim(\Input::post(\Config::get('simpleauth.username_post_key', 'username')));
	// 	$password = trim($password) ?: trim(\Input::post(\Config::get('simpleauth.password_post_key', 'password')));

	// 	if (empty($username_or_email) or empty($password))
	// 	{
	// 		return false;
	// 	}

	// 	$password = $this->hash_password($password);
	// 	$user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
	// 		->where_open()
	// 		->where('username', '=', $username_or_email)
	// 		->or_where('email', '=', $username_or_email)
	// 		->where_close()
	// 		->where('password', '=', $password)
	// 		->from(\Config::get('simpleauth.table_name'))
	// 		->execute(\Config::get('simpleauth.db_connection'))->current();

	// 	return $user ?: false;
	// }

	/**
	 * Login user
	 *
	 * @param   string
	 * @param   string
	 * @return  bool
	 */
	// public function login($username_or_email = '', $password = '')
	// {
	// 	if ( ! ($this->user = $this->validate_user($username_or_email, $password)))
	// 	{
	// 		$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
	// 		\Session::delete('username');
	// 		\Session::delete('login_hash');
	// 		return false;
	// 	}

	// 	// register so Auth::logout() can find us
	// 	Auth::_register_verified($this);

	// 	\Session::set('username', $this->user['username']);
	// 	\Session::set('login_hash', $this->create_login_hash());
	// 	\Session::instance()->rotate();
	// 	return true;
	// }

	/**
	 * Force login user
	 *
	 * @param   string
	 * @return  bool
	 */
	// public function force_login($user_id = '')
	// {
	// 	if (empty($user_id))
	// 	{
	// 		return false;
	// 	}

	// 	$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
	// 		->where_open()
	// 		->where('id', '=', $user_id)
	// 		->where_close()
	// 		->from(\Config::get('simpleauth.table_name'))
	// 		->execute(\Config::get('simpleauth.db_connection'))
	// 		->current();

	// 	if ($this->user == false)
	// 	{
	// 		$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
	// 		\Session::delete('username');
	// 		\Session::delete('login_hash');
	// 		return false;
	// 	}

	// 	\Session::set('username', $this->user['username']);
	// 	\Session::set('login_hash', $this->create_login_hash());

	// 	// and rotate the session id, we've elevated rights
	// 	\Session::instance()->rotate();

	// 	// register so Auth::logout() can find us
	// 	Auth::_register_verified($this);

	// 	return true;
	// }

	// /**
	//  * Logout user
	//  *
	//  * @return  bool
	//  */
	// public function logout()
	// {
	// 	$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
	// 	\Session::delete('username');
	// 	\Session::delete('login_hash');
	// 	return true;
	// }

	/**
	 * Create new user
	 *
	 * @param   string
	 * @param   string
	 * @param   string  must contain valid email address
	 * @param   int     group id
	 * @param   Array
	 * @return  bool
	 */
	public function create_user($username, $password, $email, $group = 1, Array $profile_fields = array())
	{
		$password = trim($password);
		// $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

		// if (empty($username) or empty($password) or empty($email))
		// {
		// 	throw new \SimpleUserUpdateException('Username, password or email address is not given, or email address is invalid', 1);
		// }

		// $same_users = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
		// 	->where('username', '=', $username)
		// 	->or_where('email', '=', $email)
		// 	->from(\Config::get('simpleauth.table_name'))
		// 	->execute(\Config::get('simpleauth.db_connection'));

		// if ($same_users->count() > 0)
		// {
		// 	if (in_array(strtolower($email), array_map('strtolower', $same_users->current())))
		// 	{
		// 		throw new \SimpleUserUpdateException('Email address already exists', 2);
		// 	}
		// 	else
		// 	{
		// 		throw new \SimpleUserUpdateException('Username already exists', 3);
		// 	}
		// }

		$user = array(
			'username'        => (string) $username,
			'password'        => $this->hash_password((string) $password),
			'email'           => $email,
			'group'           => (int) $group,
			'profile_fields'  => serialize($profile_fields),
			'last_login'      => 0,
			'login_hash'      => '',
			'created_at'      => \Date::forge()->get_timestamp(),
		);
		$result = \DB::insert(\Config::get('simpleauth.table_name'))
			->set($user)
			->execute(\Config::get('simpleauth.db_connection'));

		return ($result[1] > 0) ? $result[0] : false;
	}

	/**
	 * Update a user's properties
	 * Note: Username cannot be updated, to update password the old password must be passed as old_password
	 *
	 * @param   Array  properties to be updated including profile fields
	 * @param   string
	 * @return  bool
	 */
	
}

// end of file simpleauth.php
