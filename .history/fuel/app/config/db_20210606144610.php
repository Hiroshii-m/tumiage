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

/**
 * -----------------------------------------------------------------------------
 *  Global database settings
 * -----------------------------------------------------------------------------
 *
 *  Set database configurations here to override environment specific
 *  configurations
 *
 */
return array(
    // 'active' => 'mysqli',
    'active' => 'lolipop',
    /**
     * Base config, just need to set the DSN, username and password in env. config.
     */
    'default' => array(
        'type'        => 'pdo',
        'connection'  => array(
            'persistent' => false,
        ),
        'identifier'   => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => false,
    ),

    'redis' => array(
        'default' => array(
            'hostname'  => '127.0.0.1',
            'port'      => 6379,
        )
    ),

    'mysqli' => array(
        'type'   => 'mysqli',
        'connection' => array(
            'hostname'   => 'localhost',
            'database'   => 'studydata',
            'port'       => '8888',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => false,
            'compress'   => false,
        ),
        'identifier'     => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => true,
    ),
    'lolipop' => array(
        'type'        => 'pdo',
        'connection'  => array(
            'dsn'        => 'mysql:host=mysql153.phy.lolipop.lan;dbname=LAA1303831-tumiage;unix_socket=/var/lib/mysql/mysql.sock',
            'username'   => 'LAA1303831',
            'password'   => 'sakkasanhe',
            'persistent' => false,
            'compress'   => false,
        ),
        'identifier'   => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => false,
    ),
);
