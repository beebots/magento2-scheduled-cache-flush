<?php

namespace BeeBots\ScheduledCacheFlush\Model;

use Magento\Framework\Model\AbstractModel;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;

class ScheduledCacheFlush extends AbstractModel
{
    public const ID = 'id';
    public const FLUSH_TIME = 'flush_time';
    public const FLUSH_TAGS = 'flush_tags';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

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
     * @return array|mixed|null
     */
    public function getId(): mixed
    {
        return parent::getData(self::ID);
    }

    /**
     * Function: getFlushTime
     *
     * @return array|mixed|null
     */
    public function getFlushTime(): mixed
    {
        return parent::getData(self::FLUSH_TIME);
    }

    /**
     * Function: getFlushTags
     *
     * @return array|mixed|null
     */
    public function getFlushTags(): mixed
    {
        return parent::getData(self::FLUSH_TAGS);
    }

    /**
     * Function: getCreatedAt
     *
     * @return array|mixed|null
     */
    public function getCreatedAt(): mixed
    {
        return parent::getData(self::CREATED_AT);
    }

    /**
     * Function: getUpdatedAt
     *
     * @return array|mixed|null
     */
    public function getUpdatedAt(): mixed
    {
        return parent::getData(self::UPDATED_AT);
    }

    /**
     * Function: setId
     *
     * @param int $id
     *
     * @return ScheduledCacheFlush
     */
    public function setId($id): ScheduledCacheFlush
    {
        return parent::setData(self::ID, $id);
    }

    /**
     * Function: setFlushTime
     *
     * @param string $flushTime
     *
     * @return ScheduledCacheFlush
     */
    public function setFlushTime(string $flushTime): ScheduledCacheFlush
    {
        return parent::setData(self::FLUSH_TIME, $flushTime);
    }

    /**
     * Function: setFlushTags
     *
     * @param array $flushTags
     *
     * @return ScheduledCacheFlush
     */
    public function setFlushTags(array $flushTags): ScheduledCacheFlush
    {
        return parent::setData(self::FLUSH_TAGS, $flushTags);
    }

    /**
     * Function: setCreatedAt
     *
     * @param string $createdAt
     *
     * @return ScheduledCacheFlush
     */
    public function setCreatedAt(string $createdAt): ScheduledCacheFlush
    {
        return parent::setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Function: setUpdatedAt
     *
     * @param string $updatedAt
     *
     * @return ScheduledCacheFlush
     */
    public function setUpdatedAt(string $updatedAt): ScheduledCacheFlush
    {
        return parent::setData(self::UPDATED_AT, $updatedAt);
    }
}
