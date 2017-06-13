<?php

namespace Ethereum;

use JsonRpc\Client as JsonRpcClient;
use Exceptions;

/**
 * Ethereum JSON-RPC and IPC API interface
 *
 * See Ethereum API documentation for more information:
 * http://ethereum.gitbooks.io/frontier-guide/content/rpc.html
 */

class EthRpc extends JsonRpcClient implements EthereumTransport
{
    public function etherRequest($method, $params = array())
    {
        try {
            $this->call($method, $params);
            return $this->result;
        } catch (Exceptions\RpcException $e) {
            throw $e;
        }
    }
}
