<?php

namespace App\Websocket\Topic;

use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class MessageTopic implements TopicInterface
{
    /**
     * Handles subscription requests for this topic.
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request): void
    {
        // This will broadcast a message to all subscribers of this topic notifying them of the new subscriber.
        $topic->broadcast(['msg' => $connection->resourceId.' has joined '.$topic->getId()]);
    }

    /**
     * Handles unsubscription requests for this topic.
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request): void
    {
        // This will broadcast a message to all subscribers of this topic notifying them of the unsubscribing user.
        $topic->broadcast(['msg' => $connection->resourceId.' has left '.$topic->getId()]);
    }

    /**
     * Handles publish requests for this topic.
     *
     * @param mixed $event The event data
     */
    public function onPublish(
        ConnectionInterface $connection,
        Topic $topic,
        WampRequest $request,
        $event,
        array $exclude,
        array $eligible
    ): void {
        // This will broadcast a message to all subscribers of this topic.
        $topic->broadcast(['msg' => $event]);
    }

    /**
     * Name of the topic.
     */
    public function getName(): string
    {
        return 'Message.topic';
    }
}
