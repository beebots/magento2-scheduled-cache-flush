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
     * @param ScheduledCacheFlushInterface $scheduledCacheFlush
     *
     * @return ScheduledCacheFlushInterface
     */
    public function save(ScheduledCacheFlushInterface $scheduledCacheFlush): ScheduledCacheFlushInterface;
}
