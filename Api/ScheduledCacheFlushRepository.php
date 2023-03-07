<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection PhpUnused */

namespace BeeBots\ScheduledCacheFlush\Api;

use BeeBots\ScheduledCacheFlush\Api\Data\ScheduledCacheFlushInterface;
use BeeBots\ScheduledCacheFlush\Model\ResourceModel\ScheduledCacheFlush as ScheduledCacheFlushResource;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlush;
use BeeBots\ScheduledCacheFlush\Model\ScheduledCacheFlushFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Throwable;

/**
 * CMS page CRUD interface.
 * @api
 * @since 100.0.2
 */
class ScheduledCacheFlushRepository implements ScheduledCacheFlushRepositoryInterface
{
    private ScheduledCacheFlushResource $scheduledCacheFlushResource;

    private ScheduledCacheFlushFactory $scheduledCacheFlushFactory;

    /**
     * @param ScheduledCacheFlushResource $scheduledCacheFlushResource
     * @param ScheduledCacheFlushFactory $scheduledCacheFlushFactory
     */
    public function __construct(
        ScheduledCacheFlushResource $scheduledCacheFlushResource,
        ScheduledCacheFlushFactory $scheduledCacheFlushFactory
    ) {
        $this->scheduledCacheFlushResource = $scheduledCacheFlushResource;
        $this->scheduledCacheFlushFactory = $scheduledCacheFlushFactory;
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
        $scheduledCacheFlushId = $scheduledCacheFlush->getId();
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
}
