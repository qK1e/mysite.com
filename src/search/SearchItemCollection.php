<?php

namespace qk1e\mysite\search;

use Iterator;
use qk1e\mysite\model\entities\Article;
use qk1e\mysite\model\entities\Developer;

class SearchItemCollection implements Iterator
{
    private $collection = array();
    private $position = 0;

    public function add(array $items)
    {
        foreach ($items as $item)
        {
            $class = get_class($item);

            if($class == Article::class)
            {
                $search_item = new SearchItem();
                $search_item->setType("blog");
                $search_item->setItem($item);

                array_push($this->collection, $search_item);
            }
            if($class == Developer::class)
            {
               $search_item = new SearchItem();
               $search_item->setType("dev");
               $search_item->setItem($item);

               array_push($this->collection, $search_item);
            }
        }
    }

    /**
     * Return the current element
     *
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current(): ?SearchItem
    {
        $item = $this->collection[$this->position];

        if($item)
        {
            return $item;
        }
        else
        {
            return false;
        }
    }

    /**
     * Move forward to next element
     *
     * @link https://php.net/manual/en/iterator.next.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function next(): ?SearchItem
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}