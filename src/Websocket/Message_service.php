<?php

namespace App\Websocket\Rpc;

use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Ratchet\ConnectionInterface;

final class MessageRpc implements RpcInterface
{
  /**
     * Adds the params together.
     */
    public function sum(ConnectionInterface $connection, WampRequest $request, $params): array
    {
        return ['result' => array_sum($params)];
    }

  /**
     * Name of the RPC handler.
     */
    public function getName(): string
    {
        return 'Message.rpc';
    }
}
