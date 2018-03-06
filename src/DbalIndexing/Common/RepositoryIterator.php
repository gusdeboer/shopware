<?php declare(strict_types=1);

namespace Shopware\DbalIndexing\Common;

use Shopware\Api\Entity\RepositoryInterface;
use Shopware\Api\Entity\Search\Criteria;
use Shopware\Api\Entity\Search\SearchResultInterface;
use Shopware\Context\Struct\ShopContext;

class RepositoryIterator
{
    /**
     * @var Criteria
     */
    private $criteria;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ShopContext
     */
    private $context;

    public function __construct(RepositoryInterface $repository, ShopContext $context, Criteria $criteria = null)
    {
        if ($criteria === null) {
            $criteria = new Criteria();
            $criteria->setOffset(0);
            $criteria->setLimit(50);
        }

        $this->criteria = $criteria;
        $this->repository = $repository;
        $this->context = $context;
    }

    public function getTotal(): int
    {
        $criteria = clone $this->criteria;
        $criteria->setOffset(0);
        $criteria->setLimit(1);
        $criteria->setFetchCount(true);

        $result = $this->repository->searchIds($criteria, $this->context);

        return $result->getTotal();
    }

    public function fetchIds(): ?array
    {
        $this->criteria->setFetchCount(false);
        $ids = $this->repository->searchIds($this->criteria, $this->context);
        $this->criteria->setOffset($this->criteria->getOffset() + $this->criteria->getLimit());

        if (!empty($ids->getIds())) {
            return $ids->getIds();
        }

        return null;
    }

    public function fetch(): ?SearchResultInterface
    {
        $this->criteria->setFetchCount(false);
        $result = $this->repository->search($this->criteria, $this->context);
        $this->criteria->setOffset($this->criteria->getOffset() + $this->criteria->getLimit());

        if (empty($result->getIdResult()->getIds())) {
            return null;
        }

        return $result;
    }
}