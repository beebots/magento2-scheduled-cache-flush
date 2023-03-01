<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\CollectionFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'BeeBots_ScheduledCacheFlush::manage';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Filter
     */
    protected $filter;

    private ScheduledCacheFlush $scheduledCacheFlushResource;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ScheduledCacheFlush $scheduledCacheFlushResource
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ScheduledCacheFlush $scheduledCacheFlushResource
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;

        parent::__construct($context);
    }

    /**
     * Function: execute
     *
     * @return Redirect
     * @throws NotFoundException
     * @throws LocalizedException
     * @throws Exception
     */
    public function execute(): Redirect
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $deletedCount = 0;
        foreach ($collection->getItems() as $scheduledCacheFlush) {
            $this->scheduledCacheFlushResource->delete($scheduledCacheFlush);
            $deletedCount++;
        }

        if ($deletedCount) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $deletedCount)
            );
        }

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('scheduled_cache_flush/manage/index');
    }
}
