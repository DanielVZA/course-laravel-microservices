<?php

namespace App\Queues;

use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class KafkaQueue extends Queue implements QueueContract
{
    protected $consumer;
    protected $producer;

    public function __construct($producer, $consumer)
    {
        $this->producer = $producer;
        $this->consumer = $consumer;
    }

    public function size($queue = null)
    {
    }

    public function push($job, $data = '', $queue = null)
    {
        $topic = $this->producer->newTopic("default");
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, serialize($job));
        $this->producer->flush(5000);
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
    }

    public function pop($queue = null)
    {
        $this->consumer->subscribe(['default']);
        $message = $this->consumer->consume(120 * 1000);

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                var_dump($message->payload);
                break;
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                break;
            default:
                throw new \Exception($message->errstr(), $message->err);
                break;
        }
    }
}
