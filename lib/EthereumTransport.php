<?php

namespace Ethereum;

use Exceptions;

interface EthereumTransport
{
    public function etherRequest($method, $params = array());
}
