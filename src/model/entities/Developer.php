<?php


namespace qk1e\mysite\model\entities;


use qk1e\mysite\model\MysqlUsersDatabase;

class Developer
{
    private $id;
    private $user_id;
    private $profile_id;
    private $first_name;
    private $second_name;
    private $about;
    private $photo;

    /**
     * Developer constructor.
     *
     * @param  \qk1e\mysite\model\entities\User  $user
     */
    public function __construct(User $user=null)
    {
        if($user != null)
        {
            $DB = new MysqlUsersDatabase();
            $developer = $DB->getDeveloperByUserId($user->getId());

            $this->id = $developer->getId();
            $this->user_id = $developer->getUserId();
            $this->profile_id = $developer->getProfileId();
            $this->first_name = $developer->getFirstName();
            $this->second_name = $developer->getSecondName();
            $this->about = $developer->getAbout();
            $this->photo = $developer->getAvatar();
        }
    }

    /**
     * @param  mixed  $profile_id
     */
    public function setProfileId($profile_id): void
    {
        $this->profile_id = $profile_id;
    }

    public function isValid()
    {
        return isset($this->user_id);
    }

    /**
     * @param  mixed  $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param  mixed  $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param  mixed  $photo
     */
    public function setAvatar($photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    public function getProfile()
    {
        $DB = new MysqlUsersDatabase();
        $profile = $DB->getProfileByProfileId($this->profile_id);
        return $profile;
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

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    public function getAvatar()
    {
        return "./views/img/indian-developer.jpg";
    }

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
     * @param  mixed  $about
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }

    public function getFullName()
    {
        return $this->first_name." ".$this->second_name;
    }

    public function getAbout()
    {;
        $about = $this->getProfile()->getAbout();
        return $about;
    }
}