<?php


namespace qk1e\mysite\model\entities;


class Developer
{
    private $f_name;
    private $s_name;
    private $l_name;
    private $about;

    /**
     * @param mixed $f_name
     */
    public function setFName($f_name)
    {
        $this->f_name = $f_name;
    }

    /**
     * @param mixed $s_name
     */
    public function setSName($s_name)
    {
        $this->s_name = $s_name;
    }

    /**
     * @param mixed $l_name
     */
    public function setLName($l_name)
    {
        $this->l_name = $l_name;
    }

    /**
     * @param mixed $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }


    public function getImage(){
        return "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThi6yrm0NAd4yq1FR_uctbzRyNcZsd_CNJOvy2723qxX8zjqnlhA'>";
    }
    public function getName(){
        return $this->f_name." ".$this->s_name;
    }
    public function getPreview(){
        return $this->about;
    }
}