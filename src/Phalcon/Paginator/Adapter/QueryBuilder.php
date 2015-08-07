<?php

namespace Sb\Phalcon\Paginator\Adapter;

use \Phalcon\Paginator\AdapterInterface;
use \Phalcon\Paginator\Exception;
use \stdClass;

class QueryBuilder implements AdapterInterface
{
    /**
     * Configuration
     *
     * @var null|array
     * @access protected
     */
    protected $_config;

    /**
     * Builder
     *
     * @var null|object
     * @access protected
     */
    protected $_builder;

    /**
     * Limit Rows
     *
     * @var null|int
     * @access protected
     */
    protected $_limitRows;

    /**
     * Page
     *
     * @var int
     * @access protected
     */
    protected $_page;

    /**
     * \Phalcon\Paginator\Adapter\QueryBuilder
     *
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        if (is_array($config) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $this->_config = $config;
        if (isset($config['builder']) === false) {
            throw new Exception("Parameter 'builder' is required");
        } else {
            //@note no further builder validation
            $this->_builder = $config['builder'];
        }

        if (isset($config['limit']) === false) {
            throw new Exception("Parameter 'limit' is required");
        } else {
            $this->_limitRows = $config['limit'];
        }

        if (isset($config['page']) === true) {
            $this->_page = $config['page'];
        }
    }

    /**
     * Set the current page number
     *
     * @param int $currentPage
     * @throws Exception
     */
    public function setCurrentPage($currentPage)
    {
        if (is_int($currentPage) === false) {
            throw new Exception('Invalid parameter type.');
        }
        $this->_page = $currentPage;
    }

    /**
     * Returns a slice of the resultset to show in the pagination
     *
     * @return stdClass
     */
    public function getPaginate()
    {
        /* Clone the original builder */
        $builder = clone $this->_builder;
        $totalBuilder = clone $builder;

        $limit = $this->_limitRows;
        $numberPage = $this->_page;

        if (is_null($numberPage) === true) {
            $numberPage = 1;
        }

        $prevNumberPage = $numberPage - 1;
        $number = $limit * $prevNumberPage;

        //Set the limit clause avoiding negative offsets
        if ($number < $limit) {
            $builder->limit($limit);
        } else {
            $builder->limit($limit, $number);
        }

        $query = $builder->getQuery();

        //Change the queried columns by a COUNT(*)
        $totalBuilder->columns('COUNT(*) [rowcount]');

        //Remove the 'ORDER BY' clause, PostgreSQL requires this
        $totalBuilder->orderBy(null);

        //Obtain the PHQL for the total query
        $totalQuery = $totalBuilder->getQuery();

        //Obtain the result of the total query
        $result = $totalQuery->execute();
        $row = $result->getFirst();

        $totalPages = $row['rowcount'] / $limit;
        $intTotalPages = (int)$totalPages;

        if ($intTotalPages !== $totalPages) {
            $totalPages = $intTotalPages + 1;
        }

        $page = new stdClass();
        $page->first = 1;
        $page->before = ($numberPage === 1 ? 1 : ($numberPage - 1));
        $page->items = $query->execute();
        $page->next = ($numberPage < $totalPages ? ($numberPage + 1) : $totalPages);
        $page->last = $totalPages;
        $page->current = $numberPage;
        $page->total_pages = $totalPages;
        $page->total_items = (int)$row['rowcount'];

        return $page;
    }
}
