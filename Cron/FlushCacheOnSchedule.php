<?php

namespace BeeBots\ScheduledCacheFlush\Cron;

use BeeBots\ScheduledCacheFlush\Model\Config;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZoneFactory;
use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use BeeBots\ScheduledCacheFlush\Utilities\ConvertMultilineTextToArray;
use DateTime;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class CacheFlusher
 *
 * @package BeeBots\ScheduledCacheFlush\Cron
 */
class FlushCacheOnSchedule
{
    /** @var Config */
    private $config;

    /** @var ConvertMultilineTextToArray */
    private $convertMultilineTextToArray;

    /** @var TimezoneInterface */
    private $timezone;

    /** @var DateTimeFactory */
    private $dateTimeFactory;

    /** @var DateTimeZoneFactory */
    private $dateTimeZoneFactory;

    /** @var CacheFlusher */
    private $cacheFlusher;

    /**
     * CacheFlusher constructor.
     *
     * @param Config $config
     * @param ConvertMultilineTextToArray $convertMultilineTextToArray
     * @param TimezoneInterface $timezone
     * @param DateTimeFactory $dateTimeFactory
     * @param DateTimeZoneFactory $dateTimeZoneFactory
     * @param CacheFlusher $cacheFlusher
     */
    public function __construct(
        Config $config,
        ConvertMultilineTextToArray $convertMultilineTextToArray,
        TimezoneInterface $timezone,
        DateTimeFactory $dateTimeFactory,
        DateTimeZoneFactory $dateTimeZoneFactory,
        CacheFlusher $cacheFlusher
    ) {
        $this->config = $config;
        $this->convertMultilineTextToArray = $convertMultilineTextToArray;
        $this->timezone = $timezone;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->dateTimeZoneFactory = $dateTimeZoneFactory;
        $this->cacheFlusher = $cacheFlusher;
    }

    /**
     * Function: execute
     *
     */
    public function execute(): FlushCacheOnSchedule
    {
        if (! $this->config->isEnabled()) {
            return $this;
        }
        $flushTimesConfig = $this->config->getFlushTimes();
        if ($flushTimesConfig === '') {
            return $this;
        }

        $storeTimeZoneString = $this->timezone->getConfigTimezone();
        $timeZone = $this->dateTimeZoneFactory->create(['timezone' => $storeTimeZoneString]);

        $flushTimeStrings = $this->convertMultilineTextToArray->execute($flushTimesConfig);
        $flushTimes = [];
        foreach ($flushTimeStrings as $flushTimeString) {
            $flushTimes[] = $this->dateTimeFactory->create($flushTimeString, $timeZone);
        }

        // Sort the dates low to high
        sort($flushTimes);

        $shouldFlush = false;
        $firstIndexToKeep = null;
        $currentTime = $this->dateTimeFactory->create('now', $timeZone);

        // Determine if we should flush the cache
        foreach ($flushTimes as $index => $flushTime) {
            // Stop on the first future date
            if ($flushTime > $currentTime) {
                $firstIndexToKeep = $index;
                break;
            }
            $shouldFlush = true;
        }

        if (!$shouldFlush) {
            return $this;
        }

        // Flush the cache
        $this->cacheFlusher->execute();

        // Remove past dates from the list
        $flushTimes = array_slice($flushTimes, $firstIndexToKeep);
        $flushTimeStrings = [];
        foreach ($flushTimes as $flushTime) {
            $flushTimeStrings[] = $flushTime->format(DateTime::W3C);
        }
        // Write the remaining flush times back to the config
        $flushTimesConfig = count($flushTimeStrings) > 0
            ? implode(PHP_EOL, $flushTimeStrings)
            : '';

        $this->config->setFlushTimes($flushTimesConfig);
        return $this;
    }
}
