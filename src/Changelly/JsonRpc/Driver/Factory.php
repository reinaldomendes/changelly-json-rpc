<?php
namespace Rbm\Changelly\JsonRpc\Driver;

use Rbm\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Rbm\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
use Rbm\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;
class Factory {
  /**
   * Create the wrapper for API changelly with correct driver
   * @param  array  $options factory options to create the wrapper with config and drivers
   * @return DriverContract  Config instance
   */
    public function factory($options){
        $_config = isset($options['config'])? $options['config'] :null;
        $_type = isset($options['type']) ? $options['type'] : null;
        return $this->createDriver($_type,$_config);
    }

    /**
     * Create the config for the API;
     * @param  string $type    type of the config (env|...)
     * @param  array  $options options pass to the class constructor
     * @return DriverContract         a config contract instance
     */
    protected function createDriver($type,ConfigContract $config){
      $configNamespace = "Rbm\\Changelly\\JsonRpc\Driver\\";
      $contract = DriverContract::class;
      if(class_exists($type)){
        $class = $type;
      }else{
        $class = "{$configNamespace}" . ucfirst($type);
      }
      if (!class_exists($class) ){
        throw new ClassNotFoundException("Class not Found for '{$type}' please use one of '{$configNamespace}' or implement new one with the contract '{$contract}'");
      }
      $implements = class_implements($class);

      if (!isset($implements[$contract])) {
        throw new InvalidContractException("Config not implement the contract '{$contract}'");
      }
      $instance =  new $class();
      $instance->setConfig($config);
      return $instance;
    }
}
