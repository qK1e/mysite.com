<?php

namespace qk1e\mysite\controllers;

use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\MysqlDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\routing\ConfigurableRouter;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\storage\LocalStorage;
use qk1e\mysite\view\View;


class ProfileController
{
    public function getProfilePage(Request $request)
    {

        $user_role = SecuritySystem::currentUserRole();
        $user = SecuritySystem::currentUser(); //must be User type with id and stuff
        if($user_role == ROLE_UNAUTHORIZED)
        {
            $router = ConfigurableRouter::getInstance();
            $router->route("/login", "GET", array());
        }
        elseif($user_role == ROLE_READER)
        {
            header("HTTP/1.0 404 Not Found");
        }
        else
        {
            $developer = new Developer($user);
            $args = array();
            if($developer->isValid())
            {
                $args["developer"] = $developer;
                $args["user_role"] = $user_role;
                $view = new View();
                $view->getPage("profile", $args);
            }
            else
            {
                echo "Developer is not valid";
            }

        }
    }

    public function getDeveloperPage(Request $request)
    {
        $args = array();

        $id = $request->getArgument("id");

        $DB = MysqlDatabase::getInstance();
        $developer =  $DB->getDeveloperById($id);
        if($developer)
        {
            $args["developer"] = $developer;
        }
        else
        {
            $error = "Oops! No such developer in database:( Please contact administrator for solving this problem!";
            $args["error"] = $error;
        }

        $user_role = SecuritySystem::currentUserRole();
        $args["user_role"] = $user_role;

        $view = new View();
        $view->getPage("developer_profile", $args);
    }

    public function saveProfile(Request $request)
    {
        $full_name = $request->getArgument("full-name");
        $about = $request->getArgument("about");
        $profile_id = $request->getArgument("profile-id");
        $developer_id = $request->getArgument("developer-id");

        if($_FILES["photo"])
        {
            $photo = $_FILES["photo"];
            if($this->validatePhoto($photo))
            {
                $file_id = LocalStorage::saveImage($photo);
                if($file_id)
                {
                    $DB = MysqlDatabase::getInstance();
                    $DB->updateProfilePhoto($profile_id, $file_id);
                }
            }
        }


        $DB = MysqlDatabase::getInstance();
        $DB->updateProfile($profile_id, $about);

        $ex_full_name = explode(" ", $full_name, 2);
        $first_name = $ex_full_name[0];
        $second_name = $ex_full_name[1];
        $DB->updateDeveloperFullName($first_name, $second_name, $developer_id);

        $router = ConfigurableRouter::getInstance();
        $router->route("/profile", "GET", array());
    }

    //
    private function getPhoto()
    {
        $photo_base64 = file_get_contents($_FILES["photo"]["tmp_name"]);
        $photo_file_type = $this->getPhotoFileType();

        $photo = 'data:image/'.$photo_file_type.';base64,'.$photo_base64;

        return $photo;
    }

    private function getPhotoFileType()
    {
        return 'jpeg';
    }

    private function validatePhoto($photo)
    {
        return !$photo["error"];
    }
}