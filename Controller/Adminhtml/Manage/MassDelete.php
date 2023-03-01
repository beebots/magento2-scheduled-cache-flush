<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Beebots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'BeeBots_ScheduledCacheFlush::manage';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    /**
     * Category delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $categoryDeleted = 0;
        foreach ($collection->getItems() as $category) {
            $this->categoryRepository->delete($category);
            $categoryDeleted++;
        }

        if ($categoryDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $categoryDeleted)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('dev_grid/index/index');
    }
}
