<?php

namespace BeeBots\ScheduledCacheFlush\Service;

use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Event\ManagerInterface;

/**
 * Class CacheFlusher
 *
 * @package BeeBots\ScheduledCacheFlush\Service
 */
class CacheFlusher
{
    /** @var Pool */
    private $cacheFrontendPool;

    /** @var ManagerInterface */
    private $eventManager;

    /**
     * CacheFlusher constructor.
     *
     * @param Pool $cacheFrontendPool
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Pool $cacheFrontendPool,
        ManagerInterface $eventManager
    ) {
        $this->cacheFrontendPool = $cacheFrontendPool;
        $this->eventManager = $eventManager;
    }

    /**
     * Function: execute
     *
     * @return $this
     */
    public function execute(): CacheFlusher
    {
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->clean();
        }
        $this->eventManager->dispatch('adminhtml_cache_flush_system');
        return $this;
    }
}
