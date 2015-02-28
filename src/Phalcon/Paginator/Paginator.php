<?php

namespace Sb\Phalcon\Paginator;

class Paginator
{
    private $items;
    private $current;
    private $before;
    private $next;
    private $last;
    private $total_pages;
    private $total_items;

    public function __construct($paginator)
    {
        $this->items = $paginator->items;
        $this->current = $paginator->current;
        $this->before = $paginator->before;
        $this->next = $paginator->next;
        $this->last = $paginator->last;
        $this->total_pages = $paginator->total_pages;
        $this->total_items = $paginator->total_items;
    }

    /**
     * @return int
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current;
    }

    /**
     * @return int
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->total_items;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->total_pages;
    }

    public function getPagesInRange($pageRange = 10)
    {
        $pageNumber = $this->getCurrentPage();
        $pageCount  = $this->getTotalPages();

        if ($pageRange > $pageCount) {
            $pageRange = $pageCount;
        }

        $delta = ceil($pageRange / 2);

        if ($pageNumber - $delta > $pageCount - $pageRange) {
            $lowerBound = $pageCount - $pageRange + 1;
            $upperBound = $pageCount;
        } else {
            if ($pageNumber - $delta < 0) {
                $delta = $pageNumber;
            }

            $offset     = $pageNumber - $delta;
            $lowerBound = $offset + 1;
            $upperBound = $offset + $pageRange;
        }

        $pages = array();

        for ($pageNumber = $lowerBound; $pageNumber <= $upperBound; $pageNumber++) {
            $pages[$pageNumber] = $pageNumber;
        }

        return $pages;
    }
} 