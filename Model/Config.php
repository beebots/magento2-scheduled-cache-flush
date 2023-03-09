<?php

namespace BeeBots\ScheduledCacheFlush\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Scheduled Cache Flush Configuration Class
 */
class Config
{
    public const ENABLED_PATH = 'beebots/scheduled_cache_flush/enabled';

    private ScopeConfigInterface $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Function: isEnabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::ENABLED_PATH);
    }
}
