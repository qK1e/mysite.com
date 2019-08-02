<?php


namespace qk1e\mysite\model\entities;


class Developer
{
    private $first_name;
    private $second_name;
    private $last_name;
    private $about;


    public function getImage(){
        return "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThi6yrm0NAd4yq1FR_uctbzRyNcZsd_CNJOvy2723qxX8zjqnlhA'>";
    }

    public function getImageFile()
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
     * @param  mixed  $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @param  mixed  $about
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }

    public function getName(){
        return $this->first_name." ".$this->second_name;
    }

    public function getPreview(){
        return $this->about;
    }
}