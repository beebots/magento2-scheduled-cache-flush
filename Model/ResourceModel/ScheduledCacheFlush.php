<?php
namespace BeeBots\ScheduledCacheFlush\Model\ResourceModel;

use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush as ScheduledCacheFlushModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Model for ScheduledCacheFlush
 */
class ScheduledCacheFlush extends AbstractDb
{
    public const TABLE_NAME = 'beebots_scheduled_cache_flush';

    /**
     * Function: _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, ScheduledCacheFlushModel::ID);
    }
}
