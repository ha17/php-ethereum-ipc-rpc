A PHP interface to the geth JSON-RPC API.  Forked from [btelle/ethereum-php](http://github.com/btelle/ethereum-php) and updated.

## Composer Installation
    composer require 'ha17/ethereum-php @dev' 

## Usage RPC
    use Ethereum\Ethereum;
    use Ethereum\EthRpc;

    $transport = new EthRpc('127.0.0.1:8545');
    $ethereum  = new Ethereum($transport);
    echo $ethereum->net_version() . PHP_EOL;

## Usage IPC
    use Ethereum\Ethereum;
    use Ethereum\EthIpc;

    $transport = new EthIpc('/path/to/ethereum.ipc'); //  see below
    $ethereum  = new Ethereum($transport);
    echo $ethereum->net_version() . PHP_EOL;

    // localtion of IPC for Parity on my Mac: ~/Library/Application\ Support/io.parity.ethereum/jsonrpc.ipc

## Function documentation
For documentation on functionality, see the [Ethereum RPC documentation](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html)

## Tests
See `tests/` directory to run phpunit tests.

## Todo
Use curl for transport by default (https://github.com/johnstevenson/jsonrpc/wiki/Advanced-functionality#client-transport)
Implement: https://github.com/ethereum/web3.js/blob/f8aa391351166316c81d7a70dcc95d695c8005db/lib/utils/utils.js
Implement IPC
