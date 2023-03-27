<?php

namespace BeeBots\ScheduledCacheFlush\Service;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Indexer\CacheContextFactory;

/**
 * Used to flush the magento full page cache
 */
class CacheFlusher
{
    private ManagerInterface $eventManager;

    private CacheContextFactory $cacheContextFactory;

    private CacheInterface $cache;

    /**
     * CacheFlusher constructor.
     *
     * @param ManagerInterface $eventManager
     * @param CacheContextFactory $cacheContextFactory
     * @param CacheInterface $cache
     */
    public function __construct(
        ManagerInterface $eventManager,
        CacheContextFactory $cacheContextFactory,
        CacheInterface $cache
    ) {
        $this->eventManager = $eventManager;
        $this->cacheContextFactory = $cacheContextFactory;
        $this->cache = $cache;
    }

    /**
     * Function: execute
     *
     * @param array $tags
     *
     * @return $this
     */
    public function execute(array $tags = ['.*']): CacheFlusher
    {
        $cacheContext = $this->cacheContextFactory->create();
        $cacheContext->registerTags($tags);
        $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $cacheContext]);
        $this->cache->clean($tags);

        return $this;
    }
}
