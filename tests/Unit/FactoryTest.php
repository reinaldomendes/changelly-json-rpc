<?php

namespace Tests\Unit;
use Tests\TestCase;
use Usebit\Changelly\JsonRpc\Factory as JsonRpcFactory;
use Usebit\Changelly\JsonRpc\Wrapper\Api as ApiWrapper;
use Usebit\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;


class FactoryTest extends TestCase{
  public function setup(){
    $this->factory = new JsonRpcFactory();

  }
  /**
   *
   *
   * @test
   */
  public function it_should_create_api_wrapper_with_default_options(){
    $wrapper = $this->factory->factory();
    $this->assertInstanceOf(ApiWrapper::class, $wrapper, "Wrapper created with default options");
  }
  /**
   *
   * @test
   */
  public function it_should_create_api_wrapper_with_config_instance(){
    $config = $this->getMockBuilder(ConfigContract::class)->getMock();
    $wrapper = $this->factory->factory([
      'config' => $config
    ]);
    $this->assertInstanceOf(ApiWrapper::class, $wrapper, "Wrapper created with default options");
  }


  /**
   * @test
   *
   */
  public function it_should_create_api_wrapper_with_driver_instance(){
    $config = $this->getMockBuilder(DriverContract::class)->getMock();
    $wrapper = $this->factory->factory([
      'driver' => $config
    ]);
    $this->assertInstanceOf(ApiWrapper::class, $wrapper, "Wrapper created with default options");
  }






}
