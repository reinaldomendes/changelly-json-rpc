<?php

namespace Rbm\Changelly\JsonRpc\Contracts;
use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;

interface Driver {

  public function setConfig(ConfigContract $config);

  function call(array $message);

}
