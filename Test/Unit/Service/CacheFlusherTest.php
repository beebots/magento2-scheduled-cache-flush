<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Indexer\CacheContext;
use Magento\Framework\Indexer\CacheContextFactory;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CacheFlusherTest extends MockeryTestCase
{
    /** @var ManagerInterface|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private ManagerInterface|Mockery\LegacyMockInterface|Mockery\MockInterface $eventManagerMock;

    /** @var CacheFlusher */
    private CacheFlusher $cacheFlusher;

    /**
     * @var Mockery\LegacyMockInterface|CacheContextFactory|Mockery\MockInterface
     */
    private Mockery\LegacyMockInterface|CacheContextFactory|Mockery\MockInterface $cacheContextFactory;

    /**
     * @var Mockery\LegacyMockInterface|CacheContext|Mockery\MockInterface
     */
    private Mockery\LegacyMockInterface|CacheContext|Mockery\MockInterface $cacheContext;

    public function setUp(): void
    {
        $this->eventManagerMock = Mockery::mock(ManagerInterface::class);
        $this->cacheContextFactory = Mockery::mock(CacheContextFactory::class);
        $this->cacheContext = Mockery::mock(CacheContext::class);

        $this->cacheFlusher = new CacheFlusher(
            $this->eventManagerMock,
            $this->cacheContextFactory
        );
    }

    public function testFlushesCache()
    {
        $this->cacheContextFactory->shouldReceive('create')
            ->andReturn($this->cacheContext);

        $tags = ['one', 'two'];
        $this->cacheContext->shouldReceive('registerTags')->withArgs([$tags]);
        $this->eventManagerMock->shouldReceive('dispatch')->once();
        $this->cacheFlusher->execute($tags);
    }
}
