<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace BeeBots\ScheduledCacheFlush\Api;

use BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface;

/**
 * CMS page CRUD interface.
 * @api
 * @since 100.0.2
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
