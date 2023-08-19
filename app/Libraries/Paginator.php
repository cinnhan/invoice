<?php

namespace App\Libraries;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

class Paginator
{

    # setting pagination default
    const PER_PAGE_DEFAULT = 10;

    const CURRENT_PAGE_DEFAULT = 1;

    const NUMBER_IS_NO_LIMIT = 1000000;

    /**
     * The total number of items before pagination
     * @var mixed
     */
    protected $total;

    /**
     * The total page of items
     * @var mixed
     */
    protected $totalPage;

    /**
     * The number of items to be shown per page
     * @var mixed
     */
    protected $perPage;

    /**
     * The current page being "viewed"
     * @var mixed
     */
    protected $currentPage;

    /**
     * is not limit
     * @var bool
     */
    protected $isNoLimit;

    /**
     * query to get data
     * @var QueryBuilder|EloquentBuilder
     */
    protected $query;

    /**
     * The entire items being paginated
     * @var Collection
     */
    protected $data;

    /**
     * Run a map over each of the items
     * @var callable
     */
    protected $itemCallback;

    public function __construct($limit = null, $page = null)
    {
        $this->setPerPage($limit);
        $this->setCurrentPage($page);
    }

    /**
     * process to paginate
     * @return void
     */
    public function process()
    {
        if ($this->isNoLimit()) {
            $data = $this->getQuery()->get();
        } else {
            $this->setTotal($this->getQuery()->toBase()->getCountForPagination());

            $this->setTotalPage(max((int) ceil($this->getTotal() / $this->getPerPage()), 1));

            $data = $this->getQuery()->forPage($this->getCurrentPage(), $this->getPerPage())->get();
        }

        $this->setData($data);
    }

    /**
     * @return mixed
     */
    public function getTotal(): mixed
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal(mixed $total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTotalPage(): mixed
    {
        return $this->totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public function setTotalPage(mixed $totalPage): void
    {
        $this->totalPage = $totalPage;
    }

    /**
     * @return mixed
     */
    public function getPerPage(): mixed
    {
        return $this->perPage;
    }

    /**
     * @param mixed $perPage
     */
    public function setPerPage(mixed $perPage): void
    {
        $isNoLimit = $perPage == Paginator::NUMBER_IS_NO_LIMIT;
        $this->setIsNoLimit($isNoLimit);

        if ( !$this->isNoLimit()) {
            $this->perPage = (int) $perPage ?: Paginator::PER_PAGE_DEFAULT;
        }
    }

    /**
     * @return mixed
     */
    public function getCurrentPage(): mixed
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage(mixed $currentPage): void
    {
        $this->currentPage = (int) $currentPage ?: Paginator::CURRENT_PAGE_DEFAULT;
    }

    /**
     * @return bool
     */
    public function isNoLimit(): bool
    {
        return $this->isNoLimit;
    }

    /**
     * @param bool $isNoLimit
     */
    public function setIsNoLimit(bool $isNoLimit): void
    {
        $this->isNoLimit = $isNoLimit;
    }

    /**
     * @return EloquentBuilder|QueryBuilder
     */
    public function getQuery(): EloquentBuilder|QueryBuilder
    {
        return $this->query;
    }

    /**
     * @param EloquentBuilder|QueryBuilder $query
     * @return $this
     */
    public function setQuery(EloquentBuilder|QueryBuilder $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        if ( !$this->data) {
            $this->process();
        }

        return $this->data;
    }

    /**
     * @param Collection $data
     */
    public function setData(Collection $data): void
    {
        $this->data = $data;
    }

    /**
     * @return null|callable
     */
    public function getItemCallback(): null|callable
    {
        return $this->itemCallback;
    }

    /**
     * @param callable $itemCallback
     */
    public function setItemCallback(callable $itemCallback): void
    {
        $this->itemCallback = $itemCallback;
    }

    /**
     * get Data Response
     * @param array $filter
     * @return array|Collection
     */
    public function getDataResponse(array $filter = [])
    {
        $data = $this->getData();
        $itemCallback = $this->getItemCallback();
        if ($itemCallback) {
            $data->map($itemCallback);
        }

        if ( !$this->isNoLimit()) {
            $total = $this->getTotal();
            $total_page = $this->getTotalPage();
            $limit = $this->getPerPage();
            $page = $this->getCurrentPage();
            $pagination = compact('total', 'total_page', 'limit', 'page');

            return compact('data', 'pagination', 'filter');
        }

        return $data;
    }

}
