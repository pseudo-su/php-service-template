<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$exchange = 'events';
$queue = 'temp_queue';
$consumerTag = 'message-processor';

$amqpHost = 'localhost';
$amqpPort = '5672';
$amqpUser = 'guest';
$amqpPass = 'guest';
$amqpVhost = '/';

$connection = new AMQPStreamConnection($amqpHost, $amqpPort, $amqpUser, $amqpPass, $amqpVhost);
$channel = $connection->channel();

/*
    name: $queue
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
$channel->queue_declare($queue, false, true, false, false);

/*
    name: $exchange
    type: topic
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false // the exchange won't be deleted once the channel is closed.
*/

$channel->exchange_declare($exchange, 'topic', false, true, false);

$channel->queue_bind($queue, $exchange, routing_key: 'test');

function process_message(\PhpAmqpLib\Message\AMQPMessage $message)
{
    echo "\n--------\n";
    echo $message->body;
    echo "\n--------\n";

    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);

    // Send a message with the string "quit" to cancel the consumer.
    if ($message->body === 'quit') {
        $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
    }
}

/*
    queue: Queue from where to get the messages
    consumer_tag: Consumer identifier
    no_local: Don't receive messages published by this consumer.
    no_ack: Tells the server if the consumer will acknowledge the messages.
    exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
    nowait:
    callback: A PHP Callback
*/

$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');

function shutdown(\PhpAmqpLib\Channel\AMQPChannel $channel, \PhpAmqpLib\Connection\AbstractConnection $connection)
{
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

// Loop as long as the channel has callbacks registered
while (count($channel->callbacks)) {
    $channel->wait();
}
