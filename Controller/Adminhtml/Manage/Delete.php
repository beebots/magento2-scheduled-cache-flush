<?php

namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpGetActionInterface
{
    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    private LoggerInterface $logger;

    /**
     * __construct
     *
     * @param Context $context
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory,
        LoggerInterface $logger
    ) {
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
        $this->logger = $logger;

        parent::__construct($context);
    }

    /**
     * Function: execute
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $id = $this->getRequest()->getParam('id');
        $scheduledCacheFlush = $this->scheduledCacheFlushFactory->create();
        $this->scheduledCacheFlushResource->load($scheduledCacheFlush, $id);

        if (! $id
            || ! $scheduledCacheFlush->getId()) {
            $this->messageManager->addErrorMessage(
                __('The scheduled cache flush could not be found so it could not be deleted')
            );
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        try {
            $this->scheduledCacheFlushResource->delete($scheduledCacheFlush);
            $this->messageManager->addSuccessMessage(__('Your the scheduled cache flush has been deleted'));
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage(
                __('There was an error while deleting the scheduled cache flush')
            );
            $this->logger->error('There was an error while deleting the scheduled cache flush', ['exception' => $exception]);
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
