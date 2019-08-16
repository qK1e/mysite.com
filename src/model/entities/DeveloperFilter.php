<?php


namespace qk1e\mysite\model\entities;


class DeveloperFilter
{
    private $first_name;
    private $second_name;

    /**
     * @param  mixed  $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @param  mixed  $second_name
     */
    public function setSecondName($second_name): void
    {
        $this->second_name = $second_name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getSecondName()
    {
        return $this->second_name;
    }


}