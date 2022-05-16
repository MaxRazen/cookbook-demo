<?php

namespace Tests\Mixins;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

trait InteractWithHttpClient
{
    public function mockHttpClient(array $handlers): void
    {
        $this->app->bind(Client::class, function () use ($handlers) {
            $mock = new MockHandler($handlers);

            $handler = HandlerStack::create($mock);

            return new Client(['handler' => $handler]);
        });
    }
}
