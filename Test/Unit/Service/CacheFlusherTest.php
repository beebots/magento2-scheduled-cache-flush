<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CacheFlusherTest extends MockeryTestCase
{
    /** @var Pool|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $cacheFrontendPoolMock;

    /** @var ManagerInterface|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $eventManagerMock;

    /** @var CacheFlusher */
    private $cacheFlusher;

    public function setUp(): void
    {
        $this->cacheFrontendPoolMock = Mockery::mock(Pool::class);
        $this->eventManagerMock = Mockery::mock(ManagerInterface::class);

        $objectManager = new ObjectManager($this);
        $this->cacheFlusher = $objectManager->getObject(
            CacheFlusher::class,
            [
                'cacheFrontendPool' => $this->cacheFrontendPoolMock,
                'eventManager' => $this->eventManagerMock,
            ]
        );
    }

    public function testFlushesCache()
    {
        $this->cacheFrontendPoolMock->shouldReceive('rewind', 'valid');
        $this->eventManagerMock->shouldReceive('dispatch')->withArgs(['adminhtml_cache_flush_system']);
        $this->cacheFlusher->execute();
    }
}
