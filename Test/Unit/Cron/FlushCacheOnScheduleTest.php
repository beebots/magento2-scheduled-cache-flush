<?php

namespace BeeBots\ScheduledCacheFlush\Test\Unit\Cron;

use BeeBots\ScheduledCacheFlush\Cron\FlushCacheOnSchedule;
use BeeBots\ScheduledCacheFlush\Model\Config;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZone;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZoneFactory;
use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use BeeBots\ScheduledCacheFlush\Utilities\ConvertMultilineTextToArray;
use DateTime;
use Exception;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FlushCacheOnScheduleTest extends MockeryTestCase
{
    /** @var FlushCacheOnSchedule */
    private $flushCacheOnSchedule;

    /** @var Config|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $configMock;

    /** @var ConvertMultilineTextToArray|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $convertMultilineTextToArrayMock;

    /** @var TimezoneInterface|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $timezoneMock;

    /** @var DateTimeFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $dateTimeFactoryMock;

    /** @var DateTimeZoneFactory|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $dateTimeZoneFactoryMock;

    /** @var CacheFlusher|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $cacheFlusherMock;

    public function setUp(): void
    {
        $this->configMock = Mockery::mock(Config::class);
        $this->convertMultilineTextToArrayMock = Mockery::mock(ConvertMultilineTextToArray::class);
        $this->timezoneMock = Mockery::mock(TimezoneInterface::class);
        $this->dateTimeFactoryMock = Mockery::mock(DateTimeFactory::class);
        $this->dateTimeZoneFactoryMock = Mockery::mock(DateTimeZoneFactory::class);
        $this->cacheFlusherMock = Mockery::mock(CacheFlusher::class);

        $objectManager = new ObjectManager($this);
        $this->flushCacheOnSchedule = $objectManager->getObject(
            FlushCacheOnSchedule::class,
            [
                'config' => $this->configMock,
                'convertMultilineTextToArray' => $this->convertMultilineTextToArrayMock,
                'timezone' => $this->timezoneMock,
                'dateTimeFactory' => $this->dateTimeFactoryMock,
                'dateTimeZoneFactory' => $this->dateTimeZoneFactoryMock,
                'cacheFlusher' => $this->cacheFlusherMock,
            ]
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

        $this->configMock->shouldReceive('getFlushTimes')
            ->once();

        $this->configMock->shouldReceive('setFlushTimes')
            ->once();

        $this->convertMultilineTextToArrayMock->shouldReceive('execute')
            ->andReturn(
                [
                    '2021-01-01',
                    '2021-02-01',
                    '2020-03-01'
                ]
            );
        $this->timezoneMock->shouldReceive('getConfigTimezone');
        $this->dateTimeZoneFactoryMock->shouldReceive('create');
        $this->cacheFlusherMock->shouldReceive('execute')
            ->once();

        $timeZone = new DateTimeZone('America/Denver');
        /** @noinspection PhpUnhandledExceptionInspection */
        $currentTime = new DateTime('2021-02-01', $timeZone);
        $this->dateTimeFactoryMock->shouldReceive('create')->andReturn(
            new DateTime('2021-01-01', $timeZone),
            new DateTime('2021-02-01', $timeZone),
            new DateTime('2021-03-01', $timeZone),
            $currentTime,
        );

        $this->flushCacheOnSchedule->execute();
    }
}
