<?php

namespace Rbm\Changelly\JsonRpc\Contracts;


interface Config {


  /**
   * Return the apiKey of changelly
   * @return string API_KEY
   */
  public function getApiKey();
  /**
   * Return the apiKey of changelly
   * @return string API_SECRET
   */
  public function getApiSecret();

}
