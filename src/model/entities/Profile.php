<?php


namespace qk1e\mysite\model\entities;


use qk1e\mysite\model\MysqlDevelopersDatabase;
use qk1e\mysite\storage\LocalStorage;

class Profile
{
    private $id;
    private $about;
    private $dev_id;
    private $photo;

    private $DB;

    /**
     * Profile constructor.
     *
     * @param $id
     * @param $about
     * @param  null  $dev_id
     * @param  null  $photo
     */
    public function __construct($id, $about, $dev_id=null, $photo=null)
    {
        $this->id = $id;
        $this->about = $about;
        $this->dev_id = $dev_id;
        $this->photo = $photo;

        $this->DB = new MysqlDevelopersDatabase();
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

    /**
     * @return null
     */
    public function getPhoto()
    {
        if($this->photo)
        {
            return LocalStorage::getFilePath($this->photo);
        }
        else
        {
            $file = $this->DB->getProfilePhoto($this->id);
            return LocalStorage::getFilePath($file);
        }
    }


}