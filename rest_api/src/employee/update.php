<?php
namespace employee;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
$requestMethod = $_SERVER["REQUEST_METHOD"];
require_once "../../../example/Psr4AutoloaderClass.php";

// instantiate the loader
$loader = new \Example\Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('DB_CRUD', '/Library/WebServer/Documents/php_perf_test/db_crud/src/');
$loader->addNamespace('REST_API', '/Library/WebServer/Documents/php_perf_test/rest_api/src/'); 

require_once('../api/Rest.php');
$db = \DB_CRUD\DB::getInstance();
$conn = $db->getConnection();

$api = new \REST_API\Api\Rest($conn);
switch($requestMethod) {	
	case 'POST':
		$api->updateEmployee($_POST);
		break;
	default:
	header("HTTP/1.0 405 Method Not Allowed");
	break;
}
?>