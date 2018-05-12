<?php

namespace Tests\Unit\Config;
use Tests\TestCase;
use Rbm\Changelly\JsonRpc\Config\Factory as ConfigFactory;
use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Rbm\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
use Rbm\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;

class FactoryTest extends TestCase{
  public function setup(){
    $this->factory = new ConfigFactory();
  }
  /**
   * Create the configuration type env
   *
   * @test
   */
  public function it_should_create_config_type_env(){
    $config = $this->factory->factory(['type' => 'env']);
    $this->assertInstanceOf(ConfigContract::class, $config, "Config should implement the contract");
  }


  /**
   * Create the configuration type env
   * @expectedException Rbm\Changelly\JsonRpc\Factory\Exception\ClassNotFound
   * @test
   */
  public function it_should_throw_exception_when_class_not_exists(){
    $this->factory->factory(['type' => '__NotExists_class__']);
  }

  /**
   * Create the configuration type env
   * @expectedException Rbm\Changelly\JsonRpc\Factory\Exception\InvalidContract
   * @test
   */
  public function it_should_throw_exception_when_class_not_implements_interface(){
    $this->factory->factory(['type'=> '\\Exception']);
  }


}
