<?php

namespace Ethereum;

/**
 *     Ethereum whisper post object
 */
class WhisperPost
{
    private $from;
    private $to;
    private $topics;
    private $payload;
    private $priority;
    private $ttl;

    public function __construct($from, $to, $topics, $payload, $priority, $ttl)
    {
        $this->from = $from;
        $this->to = $to;
        $this->topics = $topics;
        $this->payload = $payload;
        $this->priority = $priority;
        $this->ttl = $ttl;
    }

    public function toArray()
    {
        return array(
            array
            (
                'from'=>$this->from,
                'to'=>$this->to,
                'topics'=>$this->topics,
                'payload'=>$this->payload,
                'priority'=>$this->priority,
                'ttl'=>$this->ttl
            )
        );
    }
}
