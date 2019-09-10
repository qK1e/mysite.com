<?php

namespace qk1e\mysite\search;

class SearchQuery
{
    private $search_text;

    /**
     * @return mixed
     */
    public function getSearchText()
    {
        return $this->search_text;
    }

    /**
     * @param  mixed  $search_text
     */
    public function setSearchText($search_text): void
    {
        $this->search_text = $search_text;
    }


}