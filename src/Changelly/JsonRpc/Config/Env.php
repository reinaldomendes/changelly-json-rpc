<?php

namespace Usebit\Changelly\JsonRpc\Config;

use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;

/**
 * Get the config API changelly from ENV VARIABLES;
 */
class Env implements ConfigContract{

/**
 * Contains var name to get from env variables
 * @var string
 */
  protected $apiKeyVarname = 'CHANGELLY_API_KEY';
  /**
   * Contains var name to get from env variable api secret
   * @var string
   */
  protected $apiSecretVarname = 'CHANGELLY_API_SECRET';
  /**
   * Get the api info from envVars
   */
  public function __construct($options){
    $options = array_change_key_case($options,CASE_UPPER);

    if(isset($options['API_KEY_VAR_NAME'])){
      $this->apiKeyVarname = $options['API_KEY_VAR_NAME'];
    }

    if(isset($options['API_SECRET_VAR_NAME'])){
        $this->apiSecretVarname  = $options['API_SECRET_VAR_NAME'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getApiKey(){
    return getenv($this->apiKeyVarname);
  }
  /**
   * {@inheritdoc}
   */
  public function getApiSecret(){
    return getenv($this->apiSecretVarname);
  }

}
