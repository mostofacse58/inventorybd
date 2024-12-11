<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'vlmbdcom_inventory',
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

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(array(
		'driver' => in_array($db['default']['dbdriver'], array('mysql', 'mysqli')) ? 'mysql' : $db['default']['dbdriver'],
		'host' => $db['default']['hostname'],
		'database' => $db['default']['database'],
		'username' => $db['default']['username'],
		'password' => $db['default']['password'],
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => $db['default']['dbprefix'],
	)
);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$events = new Illuminate\Events\Dispatcher;
$events->listen('illuminate.query', function($query, $bindings, $time, $name) {

	// Format binding data for sql insertion

	foreach ($bindings as $i => $binding) {
		if ($binding instanceof \DateTime)  {
			$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
		} else if (is_string($binding)) {
			$bindings[$i] = "'$binding'";
		}
	}

	// Insert bindings into query
	$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
	$query = vsprintf($query, $bindings);

	// Add it into CodeIgniter
	$db =& get_instance()->db;
	$db->query_times[] = $time;
	$db->queries[] = $query;
});

$capsule->setEventDispatcher($events);
