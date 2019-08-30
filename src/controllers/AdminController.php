<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AdminController
{

    public function getAdminPage(Request $request): void
    {
        $args = array();

        $role = SecuritySystem::currentUserRole();
        $args["user_role"] = $role;

        $DB = MysqlUsersDatabase::getInstance();
        $users = $DB->getUsers();
        $args["users"] = $users;

        $view = new View();

        if($role == ROLE_UNAUTHORIZED)
        {
            $view->getPage("login", $args);
        }
        else
        {
            $view->getPage("admin", $args);
        }
    }

    public function newUser(Request $request): void
    {
        $args = array();
        $role = SecuritySystem::currentUserRole();
        $args["user_role"] = $role;

        $view = new View();

        $view->getPage("new_user",  $args);
    }

    public function updateUser(Request $request)
    {
        //get arguments
        $id = $request->getArgument("id");
        $role = $request->getArgument("role");

        //validate arguments
        $validated = true;
        if(!is_int($id))
        {
            //if string - try to get int
            if(is_string($id))
            {
                $id = trim($id);
                $id = intval($id);

                if(!$id)
                {
                    //not succeed - error
                    $validated = false;
                    $this->error("Request parameter type error!");
                }
            }
            //else - error
            else
            {
                $validated = false;
                $this->error("Request parameter type error!");
            }
        }
        if(is_string($role))
        {
            if( !($role == ROLE_READER || $role == ROLE_DEVELOPER || $role == ROLE_ADMIN) )
            {
                $validated = false;
                $this->error("Request parameter type error");
            }
        }
        else
        {
            $validated = false;
        }

        if($validated)
        {
            //update data in db
            $DB = MysqlUsersDatabase::getInstance();
            if( !($DB->updateUserRole($id, $role)) )
            {
                $this->error("Database error");
            }
            else
            {
                //send result back
                echo json_encode(array( 'success' => true ));
            }

        }
    }

    private function error($message)
    {
        echo json_encode(array('error' => $message) );
    }
}