<?php /** @noinspection PhpUnused */

namespace BeeBots\ScheduledCacheFlush\Ui\DataProvider\Manage;

use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class FormDataProvider extends AbstractDataProvider
{
    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    private RequestInterface $request;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
        $this->request = $request;
        $this->collection = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Function: getData
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $scheduledCacheFlush = $this->getCurrentScheduledCacheFlush();

        $this->loadedData = [];
        $this->loadedData[$scheduledCacheFlush->getId()]['scheduled_cache_flush'] = $scheduledCacheFlush->getData();
        return $this->loadedData;
    }

    /**
     * Function: getCurrentScheduledCacheFlush
     *
     * @return ScheduledCacheFlush
     */
    private function getCurrentScheduledCacheFlush(): ScheduledCacheFlush
    {
        $id = $this->getIdFromRequest();
        $scheduledCacheFlush = $this->scheduledCacheFlushFactory->create();
        if (!$id) {
            return $scheduledCacheFlush;
        }
        $this->scheduledCacheFlushResource->load($scheduledCacheFlush, $id, 'id');
        return $scheduledCacheFlush;
    }

    /**
     * Returns current id from request
     *
     * @return int
     */
    private function getIdFromRequest(): int
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }
}
