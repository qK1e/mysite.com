<?php

namespace qk1e\mysite\search;

class SearchItem
{
    private $type;
    private $item;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param  mixed  $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->item;
    }

    /**
     * @param  mixed  $item
     */
    public function setItem($item): void
    {
        $this->item = $item;
    }


}