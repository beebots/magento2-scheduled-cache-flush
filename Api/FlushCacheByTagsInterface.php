<?php /** @noinspection PhpUnused */

namespace BeeBots\ScheduledCacheFlush\Api;

/**
 * FlushCacheByTags right now
 *
 * @api
 */
interface FlushCacheByTagsInterface
{
    /**
     * Function: execute
     *
     * @param string[] $tags
     *
     * @return bool
     */
    public function execute(array $tags): bool;
}
