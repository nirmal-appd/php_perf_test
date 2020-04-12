<?php
namespace employee;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
$requestMethod = $_SERVER["REQUEST_METHOD"];
require_once "../../../example/Psr4AutoloaderClass.php";
include "../../../bootstrap.php";
// instantiate the loader
$loader = new \Example\Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('DB_CRUD', ROOT_DIR.'/db_crud/src/');
$loader->addNamespace('REST_API', ROOT_DIR.'/rest_api/src/'); 

require_once('../api/Rest.php');
$db = \DB_CRUD\DB::getInstance();
$conn = $db->getConnection();

$api = new \REST_API\Api\Rest($conn);

switch($requestMethod) {
	case 'GET':
		$empId = $_GET['id']??'';
		$api->deleteEmployee($empId);
		break;
	default:
	header("HTTP/1.0 405 Method Not Allowed");
	break;
}
?>