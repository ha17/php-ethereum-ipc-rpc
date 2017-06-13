<?php

namespace Ethereum;

interface EthereumTransport
{
    public function etherRequest($method, $params = array());
}
