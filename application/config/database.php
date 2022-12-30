<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	
	// LOCAL
	// 'username' => 'root',
	// 'password' => '',
	// 'database' => 'db_ppi',

	// WEB
	'username' => 'n1576051_ppiwng',
	'password' => 'primapaper2022',
	'database' => 'n1576051_ppi_mh_bk',
	// 'database' => 'n1576051_ppi',
	// 'database' => 'n1576051_ppi_bk',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
