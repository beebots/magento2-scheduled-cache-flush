<?php
namespace BeeBots\ScheduledCacheFlush\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\AbstractResource;

class ScheduledCacheFlush extends AbstractResource
{
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(\Magento\Catalog\Model\Category::ENTITY);
        }
        return parent::getEntityType();
    }
}
