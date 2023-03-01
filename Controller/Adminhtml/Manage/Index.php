<?php
namespace BeeBots\ScheduledCacheFlush\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index of Scheduled Cache Flush Records
 */
class Index extends Action implements HttpGetActionInterface
{
    protected PageFactory $resultPageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $resultPage->setActiveMenu('BeeBots_ScheduledCacheFlush::manage_index');
        $resultPage->getConfig()->getTitle()->prepend(__("Scheduled Cache Management"));
        return $resultPage;
    }
}
