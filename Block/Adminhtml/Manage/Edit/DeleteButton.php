<?php
namespace BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\Edit;

use BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * The Delete Button
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Function: getButtonData
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this cache flush ?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Function: getDeleteUrl
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getId()]);
    }
}
