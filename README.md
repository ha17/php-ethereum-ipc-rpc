A PHP interface to the geth JSON-RPC API.  Forked from [btelle/ethereum-php](http://github.com/btelle/ethereum-php) and updated.

## Composer Installation
    composer require 'ha17/ethereum-php @dev' 

## Usage
    // create a new object
    $ethereum = new Ethereum('127.0.0.1:8545');

    // do your thing
    echo $ethereum->net_version() . PHP_EOL;

## Function documentation
For documentation on functionality, see the [Ethereum RPC documentation](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html)

## Tests
See `tests/` directory to run phpunit tests.

## Todo
Use curl for transport by default (https://github.com/johnstevenson/jsonrpc/wiki/Advanced-functionality#client-transport)
Implement: https://github.com/ethereum/web3.js/blob/f8aa391351166316c81d7a70dcc95d695c8005db/lib/utils/utils.js
Implement IPC
