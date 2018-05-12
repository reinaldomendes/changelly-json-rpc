<?php

namespace Tests\Unit\Config;
use Tests\TestCase;
use Usebit\Changelly\JsonRpc\Config\Env as Config;

class EnvTest extends TestCase{



  /**
   *
   *
   * @test
   */
  public function it_should_get_api_config_from_default_variable(){
    $apiKey = 'api_key';
    $apiSecret = 'api_secret';
    putenv("CHANGELLY_API_KEY=$apiKey") ;
    putenv("CHANGELLY_API_SECRET=$apiSecret") ;
    $config = new Config([]);
    $this->assertEquals($config->getApiKey(),$apiKey);

    $this->assertEquals($config->getApiSecret(),$apiSecret);
  }
  /**
   *
   *
   * @test
   */
  public function it_should_get_api_config_from_custom_variable(){
    $apiKey = 'api_key';
    $apiSecret = 'api_secret';
    putenv("api_key=$apiKey") ;
    putenv("api_secret=$apiSecret") ;
    $config = new Config(['api_key_var_name' => 'api_key','api_secret_var_name' => 'api_secret']);
    $this->assertEquals($config->getApiKey(),$apiKey);

    $this->assertEquals($config->getApiSecret(),$apiSecret);
  }






}
