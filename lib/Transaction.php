<?php

namespace Ethereum;

/**
 *    Ethereum transaction object
 */
class Transaction
{
    private $to;
    private $from;
    private $gas;
    private $gasPrice;
    private $value;
    private $data;
    private $nonce;

    public function __construct($from, $to, $gas, $gasPrice, $value, $data = '', $nonce = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->gas = $gas;
        $this->gasPrice = $gasPrice;
        $this->value = $value;
        $this->data = $data;
        $this->nonce = $nonce;
    }

    public function toArray()
    {
        return array(
            array
            (
                'from'=>$this->from,
                'to'=>$this->to,
                'gas'=>$this->gas,
                'gasPrice'=>$this->gasPrice,
//                'value'=>$this->value,
                'data'=>$this->data,
 //               'nonce'=>$this->nonce
            )
        );
    }
}
