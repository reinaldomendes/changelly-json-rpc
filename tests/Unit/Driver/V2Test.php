<?php

namespace Tests\Unit\Driver;
use Tests\TestCase;
use Usebit\Changelly\JsonRpc\Driver\V2 as V2Driver;
// use Usebit\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Usebit\Changelly\JsonRpc\Factory\Exception\InvalidContract as InvalidContractException;
use Usebit\Changelly\JsonRpc\Factory\Exception\ClassNotFound as ClassNotFoundException;

class V2Test extends TestCase{
  public function setup(){
    $this->configMock = $this->getMockBuilder(ConfigContract::class)
                    ->getMock();
    $this->driverMock = $this->getMockBuilder(V2Driver::class)
                    ->setMethods(['request'])
                    ->getMock();



    $this->driverMock->setConfig($this->configMock);
    // $this->driver = new V2Driver($this->config);

  }

  /**
   * @test
   * @expectedException Usebit\Changelly\JsonRpc\Driver\Exception\Unauthorized
   *
   */
  public function it_will_throw_unauthorized_exception(){
    $driver = $this->driverMock;
    $this->driverMock->method('request')->willReturn('Unauthorized');
    $this->driverMock->call(['xpto' => 'oi']);
  }

  /**
   * @test
   *
   * @expectedException Usebit\Changelly\JsonRpc\Driver\Exception
   */
  public function it_will_throw_driver_exception(){
    $driver = $this->driverMock;
    $this->driverMock->method('request')->willReturn('Another Response');
    $this->driverMock->call(['xpto' => 'oi']);
  }
  /**
   *
   *
   * @test
   */
  public function it_will_call_request_method_when_we_call(){
    $driver = $this->driverMock;
    $arrayResponse = ['response' => 'ok'];
    $apiKey = 'api_key';
    $apiSecret = 'api_secret';
    $arrayMessage = ['xpto' => 'oi','jsonrpc' => '2.0'];
    $jsonMessage = json_encode($arrayMessage);

    $this->configMock->expects($this->once())
                    ->method('getApiKey')
                    ->willReturn($apiKey);
    $this->configMock->expects($this->once())
                  ->method('getApiSecret')
                  ->willReturn($apiSecret);


    $this->driverMock
    ->expects($this->once())
    ->method('request')
    ->with($this->callback(function($ary) use($apiKey,$apiSecret,$jsonMessage){
      $ary = array_map(function($v){
        return strtolower(preg_replace('@\s+@','',$v));
      },$ary);

      $expectApiKey = "api-key:{$apiKey}";
      $expectContentType = 'content-type:application/json';
      $sign = hash_hmac('sha512', $jsonMessage, $apiSecret);
      $expectedHmac = "sign:{$sign}";

      return in_array($expectApiKey,$ary)
              && in_array($expectContentType, $ary)
              && in_array($expectedHmac, $ary);
    }),$this->equalTo($jsonMessage))
    ->will($this->returnValue(json_encode($arrayResponse)));



    $response = $this->driverMock->call($arrayMessage);
    $this->assertEquals($arrayResponse,$response);
  }

  /**
   * @test
   */
   public function it_will_assert_driver_url(){
       $reflectionObject = new \ReflectionObject($this->driverMock) ;
       $method = $reflectionObject->getMethod('getApiUrl');
       $method->setAccessible(true);
       $apiUrl = $method->invoke($this->driverMock);
       $this->assertEquals($apiUrl,'https://api.changelly.com');
   }

  /**
   * @test
   */
   public function it_will_call_the_request_method(){
       $driver = $this->getMockBuilder(V2Driver::class)
       ->setMethods(['getApiUrl'])->getMock();
       $driver->setConfig($this->configMock);
       $driver->expects($this->once())
              ->method('getApiUrl')->willReturn('http://www.yahoo.com.br/');
      try{
        $driver->call(['oi' => 'message']);
      }catch(\Usebit\Changelly\JsonRpc\Driver\Exception $e){

      }
   }







}
