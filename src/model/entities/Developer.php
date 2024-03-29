<?php


namespace qk1e\mysite\model\entities;


use qk1e\mysite\model\MysqlDatabase;

class Developer extends User
{
    private $id;
    private $user_id;
    private $profile_id;
    private $first_name;
    private $second_name;
    private $visibility;

    private $DB;

    /**
     * Developer constructor.
     *
     * @param  \qk1e\mysite\model\entities\User  $user
     */
    public function __construct(User $user=null)
    {
        $this->setDatabase();

        if($user != null)
        {
            parent::__construct($user);
            $DB = MysqlDatabase::getInstance();
            $developer = $DB->getDeveloperByUserId($user->getUserId());

            if(!$developer)
            {
                if($user->getRole() == ROLE_DEVELOPER || $user->getRole() == ROLE_ADMIN)
                {
                    $this->DB->createDeveloperFromUserId($user->getUserId());
                }
            }

            if($developer)
            {
                $this->id = $developer->getId();
                $this->visibility = $developer->isVisible();
                $this->user_id = $developer->getUserId();
                $this->profile_id = $developer->getProfileId();
                $this->first_name = $developer->getFirstName();
                $this->second_name = $developer->getSecondName();
            }
        }
    }

    public function isVisible()
    {
        return $this->visibility;
    }

    private function setDatabase()
    {
        $this->DB = MysqlDatabase::getInstance();
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
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserId(): int
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
        $DB = MysqlDatabase::getInstance();
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


    public function getFullName()
    {
        return $this->first_name." ".$this->second_name;
    }

    public function getAbout()
    {
        $about = $this->getProfile()->getAbout();
        return $about;
    }
}