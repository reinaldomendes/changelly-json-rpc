<?php

namespace Tests\Unit\Wrapper;
use Tests\TestCase;
use Usebit\Changelly\JsonRpc\Wrapper\Api as ApiWrapper;
use Usebit\Changelly\JsonRpc\Contracts\Driver as DriverContract;

// use Usebit\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
// use Usebit\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;

class ApiTest extends TestCase{
  public function setup(){
    $this->driverMock = $this->getMockBuilder(DriverContract::class)
                              ->getMock();
    $this->api = new ApiWrapper($this->driverMock);
  }

  /**
   * @test
   */
  public function it_should_magic_method_call_a_driver_method_with_one_argument(){
    $expectedArgument = [
      'from' => 'ltc',
      'to' => 'btc'
    ];
    $this->driverMock->expects($this->once())
    ->method('call')
    ->with($this->callback(function($options) use($expectedArgument){
        return $options['method'] == 'getMinAmount'
        && $options['params'] == $expectedArgument
        && is_scalar($options['id']);
    }));
    $this->api->getMinAmount($expectedArgument);
  }


  /**
   * @test
   */
  public function it_should_magic_method_call_a_driver_method_with_two_arguments(){
    $expectedId = uniqid('my_id');
    $expectedArgument = [
      'from' => 'ltc',
      'to' => 'btc'
    ];
    $this->driverMock->expects($this->once())
    ->method('call')
    ->with($this->callback(function($options) use($expectedArgument,$expectedId){
        return $options['method'] == 'getMinAmount'
        && $options['params'] == $expectedArgument
        && $options['id'] == $expectedId;
    }));
    $this->api->getMinAmount($expectedId,$expectedArgument);
  }

  /**
   * @test
   * @expectedException \InvalidArgumentException
   *
   */
  public function it_should_magic_method_throw_invalid_argument_when_we_pass_three_arguments(){
    $this->api->getMinAmount(1,2,3);
  }

  /**
   * @test
   * @expectedException \InvalidArgumentException
   */
  public function it_should_magic_method_throw_invalid_argument_when_we_pass_params_inside_params(){
    $this->api->getMinAmount(['params' => []]);
  }






}
