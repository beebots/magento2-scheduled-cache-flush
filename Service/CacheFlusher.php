<?php

namespace BeeBots\ScheduledCacheFlush\Service;

use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Indexer\CacheContextFactory;

/**
 * Used to flush the magento full page cache
 */
class CacheFlusher
{
    /** @var ManagerInterface */
    private $eventManager;

    private CacheContextFactory $cacheContextFactory;

    /**
     * CacheFlusher constructor.
     *
     * @param ManagerInterface $eventManager
     * @param CacheContextFactory $cacheContextFactory
     */
    public function __construct(
        ManagerInterface $eventManager,
        CacheContextFactory $cacheContextFactory
    ) {
        $this->eventManager = $eventManager;
        $this->cacheContextFactory = $cacheContextFactory;
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

        return $this;
    }
}
