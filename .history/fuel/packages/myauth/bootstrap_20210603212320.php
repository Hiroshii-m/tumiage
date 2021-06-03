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

\Autoloader::add_core_namespace('MyAuth');

\Autoloader::add_classes(array(
	'MyAuth\\Auth_Login_Simpleauth'     => __DIR__.'/classes/auth/login/simpleauth.php',
));
