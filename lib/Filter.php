<?php

namespace Ethereum;

/**
 *    Ethereum transaction filter object
 */
class Filter
{
    private $fromBlock;
    private $toBlock;
    private $address;
    private $topics;

    public function __construct($fromBlock, $toBlock, $address, $topics)
    {
        $this->fromBlock = $fromBlock;
        $this->toBlock = $toBlock;
        $this->address = $address;
        $this->topics = $topics;
    }

    public function toArray()
    {
        return array(
            array
            (
                'fromBlock'=>$this->fromBlock,
                'toBlock'=>$this->toBlock,
                'address'=>$this->address,
                'topics'=>$this->topics
            )
        );
    }
}
