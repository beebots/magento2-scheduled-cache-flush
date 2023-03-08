<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use ArrayIterator;
use BeeBots\ScheduledCacheFlush\Cron\FlushCacheOnSchedule;
use BeeBots\ScheduledCacheFlush\Model\Config;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZone;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZoneFactory;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\Collection;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\CollectionFactory;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use DateTime;
use Exception;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Log\LoggerInterface;

class FlushCacheOnScheduleTest extends MockeryTestCase
{
    /** @var FlushCacheOnSchedule */
    private FlushCacheOnSchedule $flushCacheOnSchedule;

    /** @var Config|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private Config|Mockery\LegacyMockInterface|Mockery\MockInterface $configMock;

    /** @var TimezoneInterface|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private TimezoneInterface|Mockery\LegacyMockInterface|Mockery\MockInterface $timezoneMock;

    /** @var DateTimeFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private DateTimeFactory|Mockery\LegacyMockInterface|Mockery\MockInterface $dateTimeFactoryMock;

    /** @var DateTimeZoneFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private DateTimeZoneFactory|Mockery\LegacyMockInterface|Mockery\MockInterface $dateTimeZoneFactoryMock;

    /** @var CacheFlusher|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private CacheFlusher|Mockery\LegacyMockInterface|Mockery\MockInterface $cacheFlusherMock;

    /**
     * @var Mockery\LegacyMockInterface|CollectionFactory|Mockery\MockInterface
     */
    private Mockery\LegacyMockInterface|CollectionFactory|Mockery\MockInterface $collectionFactory;

    /**
     * @var ScheduledCacheFlushResource|Mockery\MockInterface|Mockery\LegacyMockInterface
     */
    private ScheduledCacheFlushResource|Mockery\MockInterface|Mockery\LegacyMockInterface $scheduledCacheFlushResource;

    /**
     * @var LoggerInterface|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private LoggerInterface|Mockery\LegacyMockInterface|Mockery\MockInterface $logger;

    public function setUp(): void
    {
        $this->configMock = Mockery::mock(Config::class);
        $this->timezoneMock = Mockery::mock(TimezoneInterface::class);
        $this->dateTimeFactoryMock = Mockery::mock(DateTimeFactory::class);
        $this->dateTimeZoneFactoryMock = Mockery::mock(DateTimeZoneFactory::class);
        $this->cacheFlusherMock = Mockery::mock(CacheFlusher::class);
        $this->collectionFactory = Mockery::mock(CollectionFactory::class);
        $this->scheduledCacheFlushResource = Mockery::mock(ScheduledCacheFlushResource::class);
        $this->logger = Mockery::mock(LoggerInterface::class);

        $this->flushCacheOnSchedule = new FlushCacheOnSchedule(
            $this->configMock,
            $this->timezoneMock,
            $this->dateTimeFactoryMock,
            $this->dateTimeZoneFactoryMock,
            $this->cacheFlusherMock,
            $this->collectionFactory,
            $this->scheduledCacheFlushResource,
            $this->logger,
        );
    }

    /**
     * Function: testDoesNotRunWhenDisabled
     */
    public function testDoesNotRunWhenDisabled(): void
    {
        $this->configMock->shouldReceive('isEnabled')
            ->andReturnFalse();

        $this->flushCacheOnSchedule->execute();
        $this->configMock->shouldNotHaveReceived('getFlushTimes');
    }

    /**
     * Function: testNormalUseCase
     *
     * @throws Exception
     */
    public function testNormalUseCase()
    {
        $this->configMock->shouldReceive('isEnabled')
            ->andReturnTrue();

        $this->timezoneMock->shouldReceive('getConfigTimezone');
        $this->dateTimeZoneFactoryMock->shouldReceive('create');
        $this->cacheFlusherMock->shouldReceive('execute')
            ->once();

        $timeZone = new DateTimeZone('America/Denver');
        /** @noinspection PhpUnhandledExceptionInspection */
        $currentTime = new DateTime('2021-02-01', $timeZone);
        $this->dateTimeFactoryMock->shouldReceive('create')->andReturn(
            $currentTime,
        );

        $collection = Mockery::mock(Collection::class);
        $collection->shouldReceive('addFieldToFilter', 'addOrder')
            ->andReturn($collection);

        $scheduledCacheFlush = Mockery::mock(ScheduledCacheFlush::class);
        $collection->shouldReceive('getIterator')
            ->andReturn(new ArrayIterator([$scheduledCacheFlush]));

        $scheduledCacheFlush->shouldReceive('getFlushTags')
            ->andReturn('cat_p_1234');

        $this->collectionFactory->shouldReceive('create')
            ->andReturn($collection);

        $this->scheduledCacheFlushResource->shouldReceive('delete')
            ->once();

        $this->flushCacheOnSchedule->execute();
    }
}
