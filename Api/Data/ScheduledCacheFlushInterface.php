<?php

namespace BeeBots\ScheduledCacheFlush\Api\Data;

use DateTime;

interface ScheduledCacheFlushInterface
{
    public const ID = 'id';
    public const FLUSH_TIME = 'flush_time';
    public const FLUSH_TAGS = 'flush_tags';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Function: getId
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Function: getFlushTime
     *
     * @return ?string
     */
    public function getFlushTime(): ?string;

    /**
     * Function: getFlushTags
     *
     * @return ?string
     */
    public function getFlushTags(): ?string;

    /**
     * Function: getCreatedAt
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string;

    /**
     * Function: getUpdatedAt
     *
     * @return ?string
     */
    public function getUpdatedAt(): ?string;

    /**
     * Function: setId
     *
     * @param int $id
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setId(int $id): ScheduledCacheFlushInterface;

    /**
     * Function: setFlushTime
     *
     * @param string $flushTime
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setFlushTime(string $flushTime): ScheduledCacheFlushInterface;

    /**
     * Function: setFlushTags
     *
     * @param string $flushTags
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setFlushTags(string $flushTags): ScheduledCacheFlushInterface;

    /**
     * Function: setCreatedAt
     *
     * @param string $createdAt
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setCreatedAt(string $createdAt): ScheduledCacheFlushInterface;

    /**
     * Function: setUpdatedAt
     *
     * @param string $updatedAt
     *
     * @return ScheduledCacheFlushInterface
     */
    public function setUpdatedAt(string $updatedAt): ScheduledCacheFlushInterface;
}
