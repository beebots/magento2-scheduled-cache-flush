<?php

namespace BeeBots\ScheduledCacheFlush\Cron;

use BeeBots\ScheduledCacheFlush\Model\Config;

/**
 * Class CacheFlusher
 *
 * @package BeeBots\ScheduledCacheFlush\Cron
 */
class CacheFlusher
{
    /** @var Config */
    private $config;

    /**
     * CacheFlusher constructor.
     *
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Function: execute
     *
     */
    public function execute(): void
    {
        if (! $this->config->isEnabled()) {
            return;
        }

        $flushTimes = $this->config->getFlushTimes();
        //TODO: flush the cache
    }
}
