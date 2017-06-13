<?php

namespace Tests;

use Ethereum\Ethereum;
use Ethereum\EthRpc;
use Ethereum\EthIpc;

class EthereumClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $transport = new EthRpc('http://127.0.0.1:8545');
        $this->client = new Ethereum($transport);
    }

    /**
     * Test client instantiates
     *
     * @return void
     */
    public function testClientInstantiates()
    {
        $this->assertInternalType('object', $this->client);
        $this->assertInstanceOf(Ethereum::class, $this->client);
    }

    public function testIpcWeb3Sha3()
    {
        $transport = new EthIpc('/Users/ha/jsonrpc.ipc');
        $client = new Ethereum($transport);
        $this->assertEquals($client->web3_sha3('0x68656c6c6f20776f726c64'), '0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad');
        //$this->assertEquals($client->eth_accounts(),'');
    }

    public function testRpcWeb3Sha3()
    {
        $this->assertEquals($this->client->web3_sha3('0x68656c6c6f20776f726c64'), '0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad');
    }

    public function testRpcNetVersion()
    {
        $this->assertEquals($this->client->net_version(), "17");
    }

    public function testRpcNetIsListening()
    {
        $this->assertEquals($this->client->net_listening(), true);
    }
}
