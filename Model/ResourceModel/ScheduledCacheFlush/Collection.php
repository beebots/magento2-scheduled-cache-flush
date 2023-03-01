<?php
namespace BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush as Model;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Function: _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
