# changelly-json-rpc
json-rpc-api wrappers
See the JSONRPC docs in https://api-docs.changelly.com/

[![Build Status](https://travis-ci.org/reinaldomendes/changelly-json-rpc.svg?branch=master)](https://travis-ci.org/reinaldomendes/changelly-json-rpc)
[![Coverage Status](https://coveralls.io/repos/github/reinaldomendes/changelly-json-rpc/badge.svg?branch=master)](https://coveralls.io/github/reinaldomendes/changelly-json-rpc)

## Installation
```bash
composer require reinaldomendes/changelly-json-rpc
```

## Instantiate The Api Wrapper;
```php
use Rbm\Changelly\JsonRpc\Factory as ApiFactory;
$apiFactory = new ApiFactory();
$factoryOptions = [];
$api = $apiFactory->factory($factoryOptions);
```


## Api Key and Secret
 By default the wrapper will get the env variables 'CHANGELLY_API_KEY' and 'CHANGELLY_API_SECRET'
 You can implement another method to get the API_KEY and secret.

 ```bash
 export CHANGELLY_API_KEY='myapikey';
 export CHANGELLY_API_SECRET='myscret';
 ```



## Call Any Method
You can see the method list in https://api-docs.changelly.com/

If you see the message json syntax you will see the json the keys "id", "method" and "params"
```json
{
  "id": "test",
  "jsonrpc": "2.0",
  "method": "getCurrencies",
  "params": {
  }
}
```

Follwoing the rules:
* The  *'method'* key in json message will be the method name of wrapper call.
* The *'params'* key in json will be an argument type *Array* in wrapper call.
* The *'id'* key in json will be an argument type '*string|int*' in wrapper call.


All methods can be called with 1 or 2 parameters.

`$api->getCurrencies('string',array());`

OR

`$api->getCurrencies(array());`

* NOTE: When you ommit the *'id'* param the wrapper will generate one using *uniqid*


```php

$btcAddressHash = "1TARXpabecedehdjdhsjwhduerr";
$id = "ONE_IDENTIFIER";
$params = [  
];
$response = $api->getCurrencies($id,$params); // {'id':'ONE_IDENTIFIER',....}
//or
$response = $api->getCurrencies($params);// {'id':'Rbm_xxxxxx',....}
```



## Create Transaction Example

```php

$btcAddressHash = "1TARXpabecedehdjdhsjwhduerr";
$id = "ONE_IDENTIFIER";
$params = [
    "from" => "ltc",
    "to" => "btc",
    "address" => $btcAddressHash,
    "extraId" => null,
    "amount" => 1
];

$response = $api->createTransaction($id,$params);
```



## Factory Options

### Config
    A class which implements Rbm\Changelly\JsonRpc\Contracts\Config    

   *  You can implement a contract and use the complete namespace
   *  Embed - Rbm\Changelly\JsonRpc\Config\Env
   Ex:
   ```php
      use Rbm\Changelly\JsonRpc\Factory as ApiFactory;
      $apiFactory = new ApiFactory();
      $apiFactory->factory([
        'config' => 'env' // Rbm\Changelly\JsonRpc\Config\Env - this is the default behavior
      ]);      
   ```


#### Using Your Own Config Implementation

```php
   namespace MyOwnConfig{
     use Rbm\Changelly\JsonRpc\Contracts\Config as ConfigContract;
     class config implements ConfigContract{
       public function getApiKey(){
         //... do something
         return $myApiKey;
       }
       public function getApiSecret(){
         //... do something
         return $myApiSecret;
       }
     }
   }
   ////
   ////

   use Rbm\Changelly\JsonRpc\Factory as ApiFactory;
   $apiFactory = new ApiFactory();
   $apiFactory->factory([
     'config' => MyOwnConfig\Config::class
   ]);      
```

### Driver  
An class which implements 'Rbm\Changelly\JsonRpc\Contracts\Driver'    
*  You can implement a contract and use the complete namespace
*  Embed - Rbm\Changelly\JsonRpc\Driver\V2
Ex:
```php
  use Rbm\Changelly\JsonRpc\Factory as ApiFactory;
  $apiFactory = new ApiFactory();
  $apiFactory->factory([
    'driver' => 'v2' // Rbm\Changelly\JsonRpc\Driver\V2 - this is the default behavior
  ]);      
```

## Todo
 * Implement HashCorp Vault Config - Rbm\Changelly\JsonRpc\Contracts\Vault to safelly secure API_KEYS

## History

Version 0.0.1 (Initial Build) - Create the api wrapper which works with ENV variables

## Credits

 Author - Reinaldo Barcelos Mendes (@reinaldomendes)


## License

The MIT License (MIT)

Copyright (c) 2015 Chris Kibble

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
