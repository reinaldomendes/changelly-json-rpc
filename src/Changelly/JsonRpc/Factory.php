<?php
namespace Rbm\Changelly\JsonRpc;

use Rbm\Changelly\JsonRpc\Config\Factory as ConfigFactory;
use Rbm\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Rbm\Changelly\JsonRpc\Driver\Factory as DriverFactory;
use Rbm\Changelly\JsonRpc\Wrapper\Api as ApiWrapper;

class Factory {
    /**
     * Create the wrapper for API changelly with correct driver
     * @see ConfigFactory::factory();
     * @see DriverFactory::Factory();
     * @param  array  $options factory options to create the wrapper with config and drivers
     *    default options [
     *      'config' => ['type' => 'env'],//Array(ConfigFactory::factory(Options)|ConfigContract),
     *      'driver' => ['type' => 'v2'], //Array(DriverFactory::factory(options)|DriverContract)
     *    ]
     * @return Rbm\Changelly\JsonRpc\Wrapper\Api         Api Wrapper
     */
    public function factory(array $options=[]){
      $configOptions = isset($options['config'])? $options['config'] : ['type' => 'env'];
      $driverOptions = isset($options['driver']) ? $options['driver'] : ['type' => 'v2'];

      $driver = $this->createDriver($driverOptions,$configOptions);
      return $this->createWrapper($driver);
    }

    /**
     * creates ApiWrapper Instance
     * @return Rbm\Changelly\JsonRpc\Wrapper\Api [description]
     */
    protected function createWrapper(DriverContract $driver){
        return new ApiWrapper($driver);
    }

    /**
     * Create the config instance
     * @param  array|ConfigContract  $options
     * @return Rbm\Changelly\JsonRpc\Contracts\Config        config instance
     */
    protected function createConfig($options){
      if($options instanceof ConfigContract){
        return $options;
      }

      $configFactory = new ConfigFactory();
      return $configFactory->factory($options);
    }

    /**
     * create driver contract
     * @param  array|DriverContract  $options
     * @return Rbm\Changelly\JsonRpc\Contracts\Driver          Driver contract
     */
    protected function createDriver($options,$configOptions){
      if($options instanceof DriverContract){
        return $options;
      }  
      $options['config'] = $this->createConfig($configOptions);
      $driverFactory = new DriverFactory();
      return $driverFactory->factory($options);
    }
}
