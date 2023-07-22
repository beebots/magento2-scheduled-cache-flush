<?php
namespace BeeBots\ScheduledCacheFlush\Api;

use BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface;

/**
 * ScheduledCacheFlushRepositoryInterface page CRUD interface.
 * @api
 */
interface ScheduledCacheFlushRepositoryInterface
{
    /**
     * Function: save
     *
     * @param \BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface $scheduledCacheFlush
     *
     * @return \BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface
     */
    public function save(ScheduledCacheFlushInterface $scheduledCacheFlush): ScheduledCacheFlushInterface;
}
