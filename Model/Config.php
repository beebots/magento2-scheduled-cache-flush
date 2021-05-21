<?php

namespace BeeBots\ScheduledCacheFlush\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package BeeBots\ScheduledCacheFlush\Model
 */
class Config
{
    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Function: isEnabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('beebots/scheduled_cache_flush/enabled');
    }

    /**
     * Function: getFlushTimes
     *
     * @return string
     */
    public function getFlushTimes(): string
    {
        return (int) $this->scopeConfig->getValue('beebots/scheduled_cache_flush/flush_times');
    }
}
