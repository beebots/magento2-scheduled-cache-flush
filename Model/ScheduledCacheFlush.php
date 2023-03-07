<?php

namespace BeeBots\ScheduledCacheFlush\Model;

use BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use Magento\Framework\Model\AbstractModel;

class ScheduledCacheFlush extends AbstractModel implements ScheduledCacheFlushInterface
{
    /**
     * Function: _construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ScheduledCacheFlushResource::class);
    }

    /**
     * Function: getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return parent::getData(ScheduledCacheFlushInterface::ID);
    }

    /**
     * Function: getFlushTime
     *
     * @return ?string
     */
    public function getFlushTime(): ?string
    {
        return parent::getData(ScheduledCacheFlushInterface::FLUSH_TIME);
    }

    /**
     * Function: getFlushTags
     *
     * @return ?string
     */
    public function getFlushTags(): ?string
    {
        return parent::getData(ScheduledCacheFlushInterface::FLUSH_TAGS);
    }

    /**
     * Function: getCreatedAt
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        return parent::getData(ScheduledCacheFlushInterface::CREATED_AT);
    }

    /**
     * Function: getUpdatedAt
     *
     * @return ?string
     */
    public function getUpdatedAt(): ?string
    {
        return parent::getData(ScheduledCacheFlushInterface::UPDATED_AT);
    }

    /**
     * Function: setId
     *
     * @param int $id
     *
     * @return ScheduledCacheFlushInterface
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public function setId($id): ScheduledCacheFlushInterface
    {
        return parent::setData(ScheduledCacheFlushInterface::ID, $id);
    }

    /**
     * Function: setFlushTime
     *
     * @param string $flushTime
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setFlushTime(string $flushTime): ScheduledCacheFlushInterface
    {
        return parent::setData(ScheduledCacheFlushInterface::FLUSH_TIME, $flushTime);
    }

    /**
     * Function: setFlushTags
     *
     * @param ?string $flushTags
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setFlushTags(?string $flushTags): ScheduledCacheFlushInterface
    {
        return parent::setData(ScheduledCacheFlushInterface::FLUSH_TAGS, $flushTags);
    }

    /**
     * Function: setCreatedAt
     *
     * @param string $createdAt
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setCreatedAt(string $createdAt): ScheduledCacheFlushInterface
    {
        return parent::setData(ScheduledCacheFlushInterface::CREATED_AT, $createdAt);
    }

    /**
     * Function: setUpdatedAt
     *
     * @param string $updatedAt
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setUpdatedAt(string $updatedAt): ScheduledCacheFlushInterface
    {
        return parent::setData(ScheduledCacheFlushInterface::UPDATED_AT, $updatedAt);
    }
}
