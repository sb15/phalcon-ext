<?php

namespace Sb\Phalcon\Paginator\Adapter;

use \Phalcon\Paginator\AdapterInterface;
use \Phalcon\Paginator\Exception;
use \stdClass;

class NullBuilder implements AdapterInterface
{
    /**
     * Configuration
     *
     * @var null|array
     * @access protected
     */
    protected $_config;

    /**
     *
     * @var null|object
     * @access protected
     */
    protected $_count;

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
        if (isset($config['count']) === false) {
            throw new Exception("Parameter 'count' is required");
        } else {
            $this->_count = $config['count'];
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
        $limit = $this->_limitRows;
        $numberPage = $this->_page;

        $totalPages = $this->_count / $limit;
        $intTotalPages = (int)$totalPages;

        if ($intTotalPages !== $totalPages) {
            $totalPages = $intTotalPages + 1;
        }

        $page = new stdClass();
        $page->first = 1;
        $page->before = ($numberPage === 1 ? 1 : ($numberPage - 1));
        $page->items = [];
        $page->next = ($numberPage < $totalPages ? ($numberPage + 1) : $totalPages);
        $page->last = $totalPages;
        $page->current = $numberPage;
        $page->total_pages = $totalPages;
        $page->total_items = $this->_count;

        return $page;
    }

    public function setLimit($limit)
    {
        $this->_limitRows = $limit;
    }

    public function getLimit()
    {
        return $this->_limitRows;
    }
}
