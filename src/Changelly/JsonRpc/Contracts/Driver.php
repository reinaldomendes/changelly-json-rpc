<?php

namespace Usebit\Changelly\JsonRpc\Contracts;
use Usebit\Changelly\JsonRpc\Contracts\Config as ConfigContract;

interface Driver {

  public function setConfig(ConfigContract $config);

  function call(array $message);

}
