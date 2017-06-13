<?php

namespace Ethereum;

use JsonRpc\Client as JsonRpcClient;

/**
 * Ethereum JSON-RPC and IPC API interface
 *
 * See Ethereum API documentation for more information:
 * http://ethereum.gitbooks.io/frontier-guide/content/rpc.html
 */

class EthIpc implements EthereumTransport
{
    private $ipcFilePath;
    private $socket;

    public function __construct($ipcFilePath)
    {
        $this->ipcFilePath = $ipcFilePath;
    }

    public function etherRequest($method, $params = array())
    {
        try {
            return $this->call($method, $params);
        } catch (Exceptions\RpcException $e) {
            throw $e;
        }
    }

    private function call($method, $params)
    {
        $this->connectSocket();
        $msg = $this->createMessage($method, $params);
        // print_r($msg, true);
        //die(__FILE__ . ' ' . __LINE__ . print_r($msg, true));
        $this->writeToSocket($msg);
        $jsonResult = $this->readFromSocket();
        $json = json_decode($jsonResult);
        // die(__FILE__ . ' ' . __LINE__ . print_r($result, true));
        //$result = null;
        $this->closeSocket();

        return $json->result;
    }

    private function connectSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->ipcFilePath);
    }

    private function closeSocket()
    {
        socket_close($this->socket);
    }

    private function createMessage($method, $params)
    {
        $json = new \StdClass;
        $json->jsonrpc = '2.0';
        $json->method  = $method;
        $json->params  = $params;
        $json->id      = 1;

        return json_encode($json);
    }

    private function writeToSocket($msg)
    {
        socket_sendto($this->socket, $msg, strlen($msg), 0, $this->ipcFilePath, 0);
        //socket_write($this->socket, $msg, strlen($msg));
        //echo 'Last Error: ' .  socket_last_error();
    }

    private function readFromSocket()
    {
        if (socket_recvfrom($this->socket, $buf, 64 * 1024, 0, $source) === false) {
            throw new Exceptions\RpcException('Read failed for ' . $this->ipcFilePath);
        }

        return $buf;


//         $toReturn = array();
//         while ($buffer=socket_read($this->socket, 512, PHP_BINARY_READ)) {
//             $toReturn[] = $buffer;
//             echo '...' . $buffer . PHP_EOL;
//             echo socket_last_error();
//         }
//  //die(__FILE__ . ' ' . __LINE__ . print_r($toReturn, true));
//         return implode('', $toReturn);
    }
}
