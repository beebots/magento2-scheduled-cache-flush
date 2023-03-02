<?php
namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit Scheduled Cache Flush.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization
     */
    public const ADMIN_RESOURCE = 'Magento_Backend::cache';

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
        parent::__construct($context);
    }

    /**
     * Function: execute
     *
     * @return Redirect|Page
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->scheduledCacheFlushFactory->create();

        if ($id) {
            $this->scheduledCacheFlushResource->load($model, $id, 'id');
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This scheduled cache flush no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('BeeBots_ScheduledCacheFlush::manage_index')
            ->addBreadcrumb(__('System'), __('System'))
            ->addBreadcrumb(__('Scheduled Cache Management'), __('Scheduled Cache Management'))
            ->addBreadcrumb(
                $id ? __('Edit') : __('New'),
                $id ? __('Edit') : __('New')
            );

        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? __('Edit') : __('New'));

        $resultPage->getConfig()->getTitle()->prepend(__('Scheduled Cache Flush'));

        return $resultPage;
    }
}
