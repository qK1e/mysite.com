<?php


namespace qk1e\mysite\model\entities;


class Profile
{
    private $id;
    private $about;
    private $dev_id;

    /**
     * Profile constructor.
     *
     * @param $id
     * @param $about
     * @param  null  $dev_id
     */
    public function __construct($id, $about, $dev_id=null)
    {
        $this->id = $id;
        $this->about = $about;
        $this->dev_id = $dev_id;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  mixed  $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @param  mixed  $about
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }


}