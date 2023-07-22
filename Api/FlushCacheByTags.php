<?php /** @noinspection PhpUnused */

namespace BeeBots\ScheduledCacheFlush\Api;

use BeeBots\ScheduledCacheFlush\Service\CacheFlusher;

/**
 * FlushCacheByTags right now
 *
 * @api
 */
class FlushCacheByTags implements FlushCacheByTagsInterface
{
    private CacheFlusher $cacheFlusher;

    /**
     * @param CacheFlusher $cacheFlusher
     */
    public function __construct(
        CacheFlusher $cacheFlusher
    ) {
        $this->cacheFlusher = $cacheFlusher;
    }

    /**
     * Function: execute
     *
     * @param string[] $tags
     *
     * @return bool
     */
    public function execute(array $tags = [".*"]): bool
    {
        $this->cacheFlusher->execute($tags);
        return true;
    }
}
