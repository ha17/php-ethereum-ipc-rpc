<?php

namespace Ethereum;

use Exceptions;
use \ErrorException;

/**
 * Ethereum JSON-RPC and IPC API interface
 *
 * See Ethereum API documentation for more information:
 * http://ethereum.gitbooks.io/frontier-guide/content/rpc.html
 */

class Ethereum
{
    private $transport;

    public function __construct(EthereumTransport $transport)
    {
        $this->transport = $transport;
    }

    public function encodeHex($input)
    {
        return '0x' . dechex((int)$input);
    }

    public function decodeHex($input)
    {
        if (substr($input, 0, 2) == '0x') {
            $input = substr($input, 2);
        }

        if (preg_match('/[a-f0-9]+/', $input)) {
            return hexdec($input);
        }

        return $input;
    }

    public function strHex($string)
    {
        $hexstr = unpack('H*', $string);
        return array_shift($hexstr);
    }

    public function web3_clientVersion()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function getFunctionCall($func, $value)
    {
        #return $this->truncateHexedFunction($this->web3_sha3($func)) . $this->pad($this->strHex($value));
        return $this->truncateHexedFunction($this->web3_sha3($func)) . $this->pad($value);
    }

    public function web3_sha3($input)
    {
        if (substr($input, 0, 2) <> '0x') {
            $input = '0x' . $this->strHex($input);
        }

        return $this->etherRequest(__FUNCTION__, array($input));
    }

    public function truncateHexedFunction($input)
    {
        if (substr($input, 0, 2) <> '0x') {
            return '0x' . substr($input, 0, 8);
        }

        return substr($input, 0, 10); // already has 0x
    }

    public function pad($input)
    {
        return str_pad($input, 64, '00', STR_PAD_LEFT);
    }

    public function padHex($input)
    {
        return '0x' . $this->pad($input);
    }

    public function net_version()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function net_listening()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function net_peerCount()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_protocolVersion()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_coinbase()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_mining()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_hashrate()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_gasPrice()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_accounts()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_blockNumber($decode_hex = false)
    {
        $block = $this->etherRequest(__FUNCTION__);

        if ($decode_hex) {
            $block = $this->decodeHex($block);
        }

        return $block;
    }

    public function eth_getBalance($address, $block = 'latest', $decode_hex = false)
    {
        $balance = $this->etherRequest(__FUNCTION__, array($address, $block));

        if ($decode_hex) {
            $balance = $this->decodeHex($balance);
        }

        return $balance;
    }

    public function eth_getStorageAt($address, $at, $block = 'latest')
    {
        return $this->etherRequest(__FUNCTION__, array($address, $at, $block));
    }

    public function eth_getTransactionCount($address, $block = 'latest', $decode_hex = false)
    {
        $count = $this->etherRequest(__FUNCTION__, array($address, $block));

        if ($decode_hex) {
            $count = $this->decodeHex($count);
        }

        return $count;
    }

    public function eth_getBlockTransactionCountByHash($tx_hash)
    {
        return $this->etherRequest(__FUNCTION__, array($tx_hash));
    }

    public function eth_getBlockTransactionCountByNumber($tx='latest')
    {
        return $this->etherRequest(__FUNCTION__, array($tx));
    }

    public function eth_getUncleCountByBlockHash($block_hash)
    {
        return $this->etherRequest(__FUNCTION__, array($block_hash));
    }

    public function eth_getUncleCountByBlockNumber($block = 'latest')
    {
        return $this->etherRequest(__FUNCTION__, array($block));
    }

    public function eth_getCode($address, $block = 'latest')
    {
        return $this->etherRequest(__FUNCTION__, array($address, $block));
    }

    public function eth_sign($address, $input)
    {
        return $this->etherRequest(__FUNCTION__, array($address, $input));
    }

    public function eth_sendTransaction($transaction)
    {
        if (!is_a($transaction, 'Ethereum_Transaction')) {
            throw new ErrorException('Transaction object expected');
        } else {
            return $this->etherRequest(__FUNCTION__, $transaction->toArray());
        }
    }

    public function eth_call($message, $block = 'latest')
    {
        if (!is_a($message, Message::class)) {
            throw new ErrorException('Message object expected');
        } else {
            $params = $message->toArray();
            $params[] = $block;
            return $this->etherRequest(__FUNCTION__, $params);
        }
    }

    public function eth_estimateGas($message, $block)
    {
        if (!is_a($message, Message::class)) {
            throw new ErrorException('Message object expected');
        } else {
            return $this->etherRequest(__FUNCTION__, $message->toArray());
        }
    }

    public function eth_getBlockByHash($hash, $full_tx = true)
    {
        return $this->etherRequest(__FUNCTION__, array($hash, $full_tx));
    }

    public function eth_getBlockByNumber($block = 'latest', $full_tx = true)
    {
        return $this->etherRequest(__FUNCTION__, array($block, $full_tx));
    }

    public function eth_getTransactionByHash($hash)
    {
        return $this->etherRequest(__FUNCTION__, array($hash));
    }

    public function eth_getTransactionByBlockHashAndIndex($hash, $index)
    {
        return $this->etherRequest(__FUNCTION__, array($hash, $index));
    }

    public function eth_getTransactionByBlockNumberAndIndex($block, $index)
    {
        return $this->etherRequest(__FUNCTION__, array($block, $index));
    }

    public function eth_getTransactionReceipt($tx_hash)
    {
        return $this->etherRequest(__FUNCTION__, array($tx_hash));
    }

    public function eth_getUncleByBlockHashAndIndex($hash, $index)
    {
        return $this->etherRequest(__FUNCTION__, array($hash, $index));
    }

    public function eth_getUncleByBlockNumberAndIndex($block, $index)
    {
        return $this->etherRequest(__FUNCTION__, array($block, $index));
    }

    public function eth_getCompilers()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_compileSolidity($code)
    {
        return $this->etherRequest(__FUNCTION__, array($code));
    }

    public function eth_compileLLL($code)
    {
        return $this->etherRequest(__FUNCTION__, array($code));
    }

    public function eth_compileSerpent($code)
    {
        return $this->etherRequest(__FUNCTION__, array($code));
    }

    public function eth_newFilter($filter, $decode_hex = false)
    {
        if (!is_a($filter, 'Ethereum_Filter')) {
            throw new ErrorException('Expected a Filter object');
        } else {
            $id = $this->etherRequest(__FUNCTION__, $filter->toArray());

            if ($decode_hex) {
                $id = $this->decodeHex($id);
            }

            return $id;
        }
    }

    public function eth_newBlockFilter($decode_hex = false)
    {
        $id = $this->etherRequest(__FUNCTION__);

        if ($decode_hex) {
            $id = $this->decodeHex($id);
        }

        return $id;
    }

    public function eth_newPendingTransactionFilter($decode_hex = false)
    {
        $id = $this->etherRequest(__FUNCTION__);

        if ($decode_hex) {
            $id = $this->decodeHex($id);
        }

        return $id;
    }

    public function eth_uninstallFilter($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    public function eth_getFilterChanges($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    public function eth_getFilterLogs($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    public function eth_getLogs($filter)
    {
        if (!is_a($filter, 'Ethereum_Filter')) {
            throw new ErrorException('Expected a Filter object');
        } else {
            return $this->etherRequest(__FUNCTION__, $filter->toArray());
        }
    }

    public function eth_getWork()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function eth_submitWork($nonce, $pow_hash, $mix_digest)
    {
        return $this->etherRequest(__FUNCTION__, array($nonce, $pow_hash, $mix_digest));
    }

    public function db_putString($db, $key, $value)
    {
        return $this->etherRequest(__FUNCTION__, array($db, $key, $value));
    }

    public function db_getString($db, $key)
    {
        return $this->etherRequest(__FUNCTION__, array($db, $key));
    }

    public function db_putHex($db, $key, $value)
    {
        return $this->etherRequest(__FUNCTION__, array($db, $key, $value));
    }

    public function db_getHex($db, $key)
    {
        return $this->etherRequest(__FUNCTION__, array($db, $key));
    }

    public function shh_version()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function shh_post($post)
    {
        if (!is_a($post, 'Whisper_Post')) {
            throw new ErrorException('Expected a Whisper post');
        } else {
            return $this->etherRequest(__FUNCTION__, $post->toArray());
        }
    }

    public function shh_newIdentinty()
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function shh_hasIdentity($id)
    {
        return $this->etherRequest(__FUNCTION__);
    }

    public function shh_newFilter($to=NULL, $topics=array())
    {
        return $this->etherRequest(__FUNCTION__, array(array('to'=>$to, 'topics'=>$topics)));
    }

    public function shh_uninstallFilter($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    public function shh_getFilterChanges($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    public function shh_getMessages($id)
    {
        return $this->etherRequest(__FUNCTION__, array($id));
    }

    private function etherRequest($method, $params = array())
    {
        return $this->transport->etherRequest($method, $params);
    }
}
