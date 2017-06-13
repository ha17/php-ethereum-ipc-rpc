<?php

namespace Tests;

use Ethereum\Ethereum;

class EthGetBalanceTest extends \PHPUnit_Framework_TestCase
{
    public function testEthGetBalance()
    {
        $this->client = new Ethereum('http://127.0.0.1:8545');
        $this->assertEquals($this->client->eth_getBalance('0x62d69f6867A0A084C6d313943dC22023Bc263691'), '0x0');
        $this->assertEquals($this->client->eth_getBalance('0x00ebB3273b09f66AB2e6555aAEfEDB247FAe280F'), '0x8ac7230489e80000');
    }
}
