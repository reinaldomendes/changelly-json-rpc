<?php

namespace Tests\Unit\Driver;
use Tests\TestCase;
use Usebit\Changelly\JsonRpc\Driver\Factory as DriverFactory;
use Usebit\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Usebit\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
use Usebit\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;

class FactoryTest extends TestCase{
  public function setup(){
    $this->factory = new DriverFactory();
    $this->config = $this->getMockBuilder(ConfigContract::class)
                    ->getMock();
  }
  /**
   *
   *
   * @test
   */
  public function it_should_create_driver_v2_config_type_env(){
    $driver = $this->factory->factory(['type' => 'v2','config' => $this->config]);
    $this->assertInstanceOf(DriverContract::class, $driver, "Driver v2 create with driver contract");
  }

  /**
   *
   * @expectedException Usebit\Changelly\JsonRpc\Factory\Exception\ClassNotFound
   * @test
   */
  public function it_should_throw_exception_when_class_not_exists(){
    $this->factory->factory(['type' => '__NotExists_class__','config' => $this->config]);
  }

  /**
   *
   * @expectedException Usebit\Changelly\JsonRpc\Factory\Exception\InvalidContract
   * @test
   */
  public function it_should_throw_exception_when_class_not_implements_interface(){
    $this->factory->factory(['type'=> '\\Exception','config' => $this->config]);
  }





}
