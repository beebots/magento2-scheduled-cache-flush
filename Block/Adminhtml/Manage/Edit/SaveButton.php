<?php
namespace BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\Edit;

use BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * The SaveButton Class
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Function: getButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'scheduled_cache_flush_manage_form.scheduled_cache_flush_manage_form',
                                'actionName' => 'save',
                                'params' => [
                                    'one' => 'two'
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'sort_order' => 90,
        ];
    }
}
