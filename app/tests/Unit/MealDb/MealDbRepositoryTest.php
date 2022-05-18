<?php

namespace Tests\Unit\MealDb;

use App\MealDb\MealDbApiClient;
use App\MealDb\MealDbRepository;
use PHPUnit\Framework\TestCase;

class MealDbRepositoryTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->getMockBuilder(MealDbApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testFind(): void
    {
        $this->client
            ->expects($this->once())
            ->method('find')
            ->willReturn([]);

        $repository = new MealDbRepository($this->client);

        $repository->find('::id::');
    }

    public function testSearch(): void
    {
        $this->client
            ->expects($this->once())
            ->method('search')
            ->willReturn([]);

        $repository = new MealDbRepository($this->client);

        $repository->search('example');
    }
}
