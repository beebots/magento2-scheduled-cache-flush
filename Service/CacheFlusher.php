<?php

namespace BeeBots\ScheduledCacheFlush\Service;

use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Event\ManagerInterface;

/**
 * Class CacheFlusher
 *
 * @package BeeBots\ScheduledCacheFlush\Service
 */
class CacheFlusher
{
    /** @var ManagerInterface */
    private $eventManager;

    /** @var Manager */
    private $cacheManager;

    /**
     * CacheFlusher constructor.
     *
     * @param ManagerInterface $eventManager
     * @param Manager $cacheManager
     */
    public function __construct(
        ManagerInterface $eventManager,
        Manager $cacheManager
    ) {
        $this->eventManager = $eventManager;
        $this->cacheManager = $cacheManager;
    }

    /**
     * Function: execute
     *
     * @return $this
     */
    public function execute(): CacheFlusher
    {
        $this->cacheManager->flush($this->cacheManager->getAvailableTypes());
        $this->eventManager->dispatch('adminhtml_cache_flush_system');
        return $this;
    }
}
