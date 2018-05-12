<?php
namespace Rbm\Changelly\JsonRpc\Wrapper;

use Rbm\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use InvalidArgumentException;
class Api {
    /**
     * driver to make api calls
     * @var DriverContract
     */
    protected $driver;

    public function __construct(DriverContract $driver){
      $this->driver = $driver;
    }


    /**
     * Automatic call the driver with the params
     * @param  string $name   methodname will pass as the method of the call
     * @param  array $arguments  [string,[]]|['params'] @see https://changelly.com/developers
     * @return array
     */
    public function __call($name,$arguments){
      if(count($arguments) > 2){
        throw new InvalidArgumentException("We must pass \$object->{$name}(\$id,\$params) or \$object->{$name}(\$params)");
      }

      $_params = array_reduce($arguments,function($acc,$next){
          return is_array($next) ? $next : $acc;
      },[]);


      if (isset($_params['params'])) {
          throw new InvalidArgumentException("Please not pass 'params' key in your options. EX: \$object->{$name}(['from': 'ltc','to': 'eth'])");
      }

      $id = array_reduce($arguments,function($acc,$next){
        return is_scalar($next) ? $next : $acc;
      },uniqid('Rbm_'));

      $options = [
        'method' => $name,
        'params' => $_params,
        'id' => $id,
      ];



      return $this->driver->call($options);
    }

}
