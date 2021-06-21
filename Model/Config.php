<?php

namespace BeeBots\ScheduledCacheFlush\Model;

use Magento\Config\Model\ResourceModel\Config as ConfigResource;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package BeeBots\ScheduledCacheFlush\Model
 */
class Config
{
    const ENABLED_PATH = 'beebots/scheduled_cache_flush/flush_times';
    const FLUSH_TIMES_PATH = 'beebots/scheduled_cache_flush/flush_times';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var ReinitableConfigInterface */
    private $reinitableConfig;

    /** @var ConfigResource */
    private $configResource;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ReinitableConfigInterface $reinitableConfig
     * @param ConfigResource $configResource
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ReinitableConfigInterface $reinitableConfig,
        ConfigResource $configResource
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->reinitableConfig = $reinitableConfig;
        $this->configResource = $configResource;
    }

    /**
     * Function: isEnabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->isSetFlag(self::ENABLED_PATH);
    }

    /**
     * Function: getFlushTimes
     *
     * @return string
     */
    public function getFlushTimes(): string
    {
        return (string)$this->reinitableConfig->getValue(self::FLUSH_TIMES_PATH);
    }

    /**
     * Function: setFlushTimes
     *
     * @param string $flushTimes
     *
     * @return Config
     */
    public function setFlushTimes(string $flushTimes): Config
    {
        $this->configResource->saveConfig(
            self::FLUSH_TIMES_PATH,
            $flushTimes
        );

        return $this;
    }
}
