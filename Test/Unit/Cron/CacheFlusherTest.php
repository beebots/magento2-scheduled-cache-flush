<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use BeeBots\ScheduledCacheFlush\Cron\CacheFlusher;
use BeeBots\ScheduledCacheFlush\Model\Config;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CacheFlusherTest extends MockeryTestCase
{
    /** @var CacheFlusher */
    private $cacheFlusher;

    /** @var Config|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $configMock;

    public function setUp(): void
    {
        $this->configMock = Mockery::mock(Config::class);
        $this->cacheFlusher = new CacheFlusher($this->configMock);

    }

    /**
     * Function: testCacheFlusherDoesNotRunWhenDisabled
     */
    public function testCacheFlusherDoesNotRunWhenDisabled(): void
    {
        $this->configMock->shouldReceive('isEnabled')
            ->andReturnFalse();

        $this->configMock->shouldNotHaveReceived('getFlushTimes');

        $this->cacheFlusher->execute();
    }

}
