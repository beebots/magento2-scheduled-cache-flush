<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use BeeBots\ScheduledCacheFlush\Cron\CacheFlusher;
use BeeBots\ScheduledCacheFlush\Model\Config;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
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
        $objectManager = new ObjectManager($this);
        $this->cacheFlusher = $objectManager->getObject(
            CacheFlusher::class,
            [
                'config' => $this->configMock,
            ]
        );
    }

    /**
     * Function: testCacheFlusherDoesNotRunWhenDisabled
     */
    public function testDoesNotRunWhenDisabled(): void
    {
        $this->configMock->shouldReceive('isEnabled')
            ->andReturnFalse();

        $this->cacheFlusher->execute();
        $this->configMock->shouldNotHaveReceived('getFlushTimes');
    }

    public function testRunsWhenEnabled(): void
    {
        $this->configMock->shouldReceive('isEnabled')
            ->andReturnTrue();

        $this->configMock->shouldReceive('getFlushTimes')
            ->once();

        $this->cacheFlusher->execute();
    }

}
