<?php

namespace BeeBots\ScheduledCacheFlush\Cron;

use BeeBots\ScheduledCacheFlush\Model\Config;
use BeeBots\ScheduledCacheFlush\Model\DateTimeZoneFactory;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\CollectionFactory;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;
use Exception;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Intl\DateTimeFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

/**
 * FlushCacheOnSchedule Cron Class
 *
 */
class FlushCacheOnSchedule
{
    private Config $config;

    private TimezoneInterface $timezone;

    private DateTimeFactory $dateTimeFactory;

    private DateTimeZoneFactory $dateTimeZoneFactory;

    private CacheFlusher $cacheFlusher;

    private CollectionFactory $collectionFactory;

    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private LoggerInterface $logger;

    /**
     * CacheFlusher constructor.
     *
     * @param Config $config
     * @param TimezoneInterface $timezone
     * @param DateTimeFactory $dateTimeFactory
     * @param DateTimeZoneFactory $dateTimeZoneFactory
     * @param CacheFlusher $cacheFlusher
     * @param CollectionFactory $collectionFactory
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     */
    public function __construct(
        Config $config,
        TimezoneInterface $timezone,
        DateTimeFactory $dateTimeFactory,
        DateTimeZoneFactory $dateTimeZoneFactory,
        CacheFlusher $cacheFlusher,
        CollectionFactory $collectionFactory,
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->timezone = $timezone;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->dateTimeZoneFactory = $dateTimeZoneFactory;
        $this->cacheFlusher = $cacheFlusher;
        $this->collectionFactory = $collectionFactory;
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->logger = $logger;
    }

    /**
     * Function: execute
     *
     * @return $this
     */
    public function execute(): FlushCacheOnSchedule
    {
        if (! $this->config->isEnabled()) {
            return $this;
        }

        $storeTimeZoneString = $this->timezone->getConfigTimezone();
        $timeZone = $this->dateTimeZoneFactory->create(['timezone' => $storeTimeZoneString]);
        $currentTime = $this->dateTimeFactory->create('now', $timeZone);

        $currentCacheFlushes = $this->collectionFactory->create();
        $currentCacheFlushes
            ->addFieldToFilter(ScheduledCacheFlush::FLUSH_TIME, ['lteq' => $currentTime->format('Y-m-d H:i:s')])
            ->addOrder(
                ScheduledCacheFlush::FLUSH_TIME,
                SortOrder::SORT_ASC
            );

        /** @var ScheduledCacheFlush $scheduledCacheFlush */
        foreach ($currentCacheFlushes as $scheduledCacheFlush) {
            $tags = $scheduledCacheFlush->getFlushTags()
                ? explode(' ', $scheduledCacheFlush->getFlushTags())
                : ['.*'];

            try {
                $this->cacheFlusher->execute($tags);
                $this->scheduledCacheFlushResource->delete($scheduledCacheFlush);
            } catch (Exception $exception) {
                $this->logger->error('An error occurred while attempting a scheduled cache flush', ['exception' => $exception]);
            }
        }

        return $this;
    }
}
