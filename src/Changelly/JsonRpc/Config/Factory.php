<?php
namespace Rbm\Changelly\JsonRpc\Config;

use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Rbm\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
use Rbm\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;
class Factory {
  /**
   * Create the wrapper for API changelly with correct driver
   * @param  array  $options factory options to create the wrapper with config and drivers
   * @return ConfigContract  Config instance
   */
    public function factory($options){
        $_options = isset($options['options'])? (array)$options['options'] : [];
        $_type = isset($options['type']) ? $options['type'] : null;        
        return $this->createConfig($_type,$_options);
    }

    /**
     * Create the config for the API;
     * @param  string $type    type of the config (env|...)
     * @param  array  $options options pass to the class constructor
     * @return ConfigContract         a config contract instance
     */
    protected function createConfig($type,array $options = []){
      $configNamespace = "Rbm\\Changelly\\JsonRpc\Config\\";
      $contract = ConfigContract::class;
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
      return new $class($options);
    }
}
