<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection PhpUnused */

namespace BeeBots\ScheduledCacheFlush\Api;

use BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush\Collection;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Throwable;

/**
 * ScheduledCacheFlushRepositoryInterface page CRUD interface.
 * @api
 */
class ScheduledCacheFlushRepository implements ScheduledCacheFlushRepositoryInterface
{
    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    private ScheduledCacheFlushResource\Collection $scheduledCacheFlushCollection;

    /**
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     * @param Collection $scheduledCacheFlushCollection
     */
    public function __construct(
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory,
        ScheduledCacheFlushResource\Collection $scheduledCacheFlushCollection
    ) {
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
        $this->scheduledCacheFlushCollection = $scheduledCacheFlushCollection;
    }

    /**
     * Function: save
     *
     * @param ScheduledCacheFlushInterface $scheduledCacheFlush
     *
     * @return ScheduledCacheFlushInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(ScheduledCacheFlushInterface $scheduledCacheFlush): ScheduledCacheFlushInterface
    {
        // Prevent saving duplicate cache flushes
        $duplicateCacheFlush = $this->getByDateAndTags($scheduledCacheFlush->getFlushTime(), $scheduledCacheFlush->getFlushTags());
        if ($duplicateCacheFlush->getData('id')) {
            return $scheduledCacheFlush;
        }

        $scheduledCacheFlushId = $scheduledCacheFlush->getId();
        // Updating existing scheduled cache flush if an id is available
        if ($scheduledCacheFlushId) {
            $existingScheduledCacheFlush = $this->getById($scheduledCacheFlushId);
            $mergedData = array_merge($existingScheduledCacheFlush->getData(), $scheduledCacheFlush->getData());
            $scheduledCacheFlush->setData($mergedData);
        }

        try {
            $this->scheduledCacheFlushResource->save($scheduledCacheFlush);
        } catch (Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the scheduled cache flush: %1', $exception->getMessage()),
                $exception
            );
        }

        return $scheduledCacheFlush;
    }

    /**
     * Function: getById
     *
     * @param int $id
     *
     * @return ScheduledCacheFlush
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ScheduledCacheFlush
    {
        $scheduledCacheFlush = $this->scheduledCacheFlushFactory->create();
        $this->scheduledCacheFlushResource->load($scheduledCacheFlush, $id);

        if (!$scheduledCacheFlush->getId()) {
            throw new NoSuchEntityException();
        }
        return $scheduledCacheFlush;
    }

    /**
     * Function: getByDateAndTags
     *
     * @param string|null $flushTime
     * @param string|null $flushTags
     *
     * @return DataObject
     */
    public function getByDateAndTags(?string $flushTime, ?string $flushTags): DataObject
    {
        return $this->scheduledCacheFlushCollection->addFieldToFilter(ScheduledCacheFlushInterface::FLUSH_TIME, $flushTime)
            ->addFieldToFilter(ScheduledCacheFlushInterface::FLUSH_TAGS, $flushTags)
            ->getFirstItem();
    }
}
