<?php
namespace redis;

require_once "../../example/Psr4AutoloaderClass.php";

// instantiate the loader
$loader = new \Example\Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('REDIS', '/Library/WebServer/Documents/php_perf_test/redis/src/');


class RedisOperations{

    private $redisHandler;

    //pass redis object to class property to use further
    public function __construct(object $redisObj) {
        $this->redisHandler = $redisObj;
    }

    //set redis key and value
    public function setRedisValues(string $redisOpsKey, array $redisOpsValue) {
        foreach($redisOpsValue as $key=>$value):
            $this->redisHandler->hset($redisOpsKey, $key, $value);
        endforeach;
    }

    //return redis Value based on key passed
    public function getRedisValues(string $redisOpsKey) : ?array {
        $personal_car = $this->redisHandler->hgetAll($redisOpsKey);
        return $personal_car??$personal_car;
    }
}

require "./predis/autoload.php";
\Predis\Autoloader::register();
$redis = new \Predis\Client();
$redisOps = new \REDIS\RedisOperations($redis);

$redisOpsKey='personal_car';
$redisOpsValue = array(
    "Brand" => "Fiat",
    "Model" => "Punto",
    "License" => "KA-01-9000",
    "Model Year" => 2012);
$redisOps->setRedisValues($redisOpsKey,$redisOpsValue);
$car = $redisOps->getRedisValues($redisOpsKey);

echo 'Dumping Car Info received from Redis Cache:'."<br />";

foreach($car as $carKey=>$carVal):
    echo $carKey.' is '.$carVal.'<br/>';
endforeach;