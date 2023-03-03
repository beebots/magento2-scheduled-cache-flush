<?php
namespace BeeBots\ScheduledCacheFlush\Block\Adminhtml\Manage;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

/**
 * Shared Generic Button Class
 */
class GenericButton
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * Constructor
     *
     * @param Context $context
     */
    public function __construct(
        Context $context,
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $context->getRequest();
    }

    /**
     * Function: getId
     *
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->request->getParam('id');
    }

    /**
     * Function: getUrl
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
