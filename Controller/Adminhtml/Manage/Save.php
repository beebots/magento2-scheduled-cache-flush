<?php

namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Psr\Log\LoggerInterface;

class Save extends Action implements HttpPostActionInterface
{
    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private LoggerInterface $logger;

    /**
     * __construct
     *
     * @param Context $context
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory,
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        LoggerInterface $logger
    ) {
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
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
        $scheduledCacheFlushData = $this->getRequest()->getParam('scheduled_cache_flush');
        if (! is_array($scheduledCacheFlushData)) {
            $this->messageManager->addErrorMessage("Invalid data cache flush data. Try again.");
        }

        $id = $this->getRequest()->getParam('id');
        $scheduledCacheFlush = $this->scheduledCacheFlushFactory->create();
        if ($id) {
            $this->scheduledCacheFlushResource->load($scheduledCacheFlush, $id);
        }

        $scheduledCacheFlush->setData($scheduledCacheFlushData);

        try {
            $this->scheduledCacheFlushResource->save($scheduledCacheFlush);
            $this->messageManager->addSuccessMessage('The scheduled cache flush was saved successfully');
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage('There was an error saving the scheduled cache flush');
            $this->logger->error('There was an error saving the scheduled cache flush', ['exception' => $exception]);
        }

        return $this->resultRedirectFactory->create()
            ->setPath('*/*/index');
    }
}
