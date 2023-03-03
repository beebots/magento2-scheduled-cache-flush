<?php
namespace BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\Edit;

use BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * The BackButton Class
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Function: getButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Function: getBackUrl
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
