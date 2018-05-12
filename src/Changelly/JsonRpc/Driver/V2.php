<?php

namespace Usebit\Changelly\JsonRpc\Driver;
use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;
use Usebit\Changelly\JsonRpc\Contracts\Driver as DriverContract;
use Usebit\Changelly\JsonRpc\Driver\Exception as DriverException;
use Usebit\Changelly\JsonRpc\Driver\Exception\Unauthorized as UnauthorizedException;
class V2 implements DriverContract{

  /**
   * url of the api
   * @var string
   */
  protected $apiUrl = 'https://api.changelly.com';

  /**
   * Contains Api configs
   * @var ConfigContract
   */
  protected $config;


  /**
   * set the configContract
   * @param ConfigContract $config Api config
   * @return V2
   */
  public function setConfig(ConfigContract $config){
    $this->config = $config;
    return $this;
  }

  /**
   * Call Changelly Api and return response
   * @param  array $message message to send to api
   * @return array          response of the api
   */
  public function call(array $message){
    $apiKey = $this->config->getApiKey();
    $apiSecret = $this->config->getApiSecret();
    $message['jsonrpc'] = '2.0';
    $jsonMessage = json_encode($message);
    $sign = hash_hmac('sha512', $jsonMessage, $apiSecret);

    $requestHeaders = [
        'api-key:' . $apiKey,
        'sign:' . $sign,
        'Content-type: application/json'
    ];
    $strResponse =  $this->request($requestHeaders,$jsonMessage);

    $asArray = true;
    $aryResponse = json_decode($strResponse,$asArray);
    if( null === $aryResponse){
      switch ($strResponse) {
        case 'Unauthorized':
          throw new UnauthorizedException($strResponse);
          break;
        default:
          throw new DriverException($strResponse);
          break;
      }
    }
    return $aryResponse;
  }




  /**
   * Do the curl call
   * @param  array $headers request headers
   * @param  string $body jsonMessage
   * @return string  curl response
   */
  protected function request($requestHeaders,$body){
    $ch = curl_init($this->getApiUrl());
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
    $strResponse =  curl_exec($ch);
    curl_close($ch);
    return $strResponse;
  }
  /**
   * Get the Api Url
   * @return string
   */
  protected function getApiUrl(){
    return $this->apiUrl;
  }


}
