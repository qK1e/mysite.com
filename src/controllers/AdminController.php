<?php


namespace qk1e\mysite\controllers;


use qk1e\mysite\model\entities\UserFilter;
use qk1e\mysite\model\MysqlDevelopersDatabase;
use qk1e\mysite\model\MysqlUsersDatabase;
use qk1e\mysite\Request;
use qk1e\mysite\security\SecuritySystem;
use qk1e\mysite\view\View;

class AdminController
{

    public function getAdminPage(Request $request): void
    {
        //check permissions
        $role = SecuritySystem::currentUserRole();

        if($role == ROLE_ADMIN)
        {
            $args = array();
            $args["user_role"] = $role;

            //create user filter
            $filter = new UserFilter();
            if($filter_role = $request->getArgument("role"))
            {
                $filter->setRole($filter_role);
            }
            if($username = $request->getArgument("username"))
            {
                $filter->setLogin($username);
            }
            if($first_name = $request->getArgument("first-name"))
            {
                $filter->setFirstName($first_name);
            }
            if($second_name = $request->getArgument("second-name"))
            {
                $filter->setSecondName($second_name);
            }

            //get users
            $DB = MysqlUsersDatabase::getInstance();
            $users = $DB->getUsers($filter);
            $args["users"] = $users;

            //show page
            $view = new View();
            $view->getPage("admin", $args);
        }
        elseif ($role == ROLE_UNAUTHORIZED)
        {
            $view = new View();
            $view->getPage("login", array());
        }
        else
        {
            $view = new View();
            $view->show404();
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
        //check permissions

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

    public function deleteUser(Request $request)
    {
        $user_role = SecuritySystem::currentUserRole();
        if($user_role != ROLE_ADMIN)
        {
            $this->error("access denied");
        }
        else
        {
            $id = $request->getArgument("id");
            $DB = MysqlUsersDatabase::getInstance();

            $DB->deleteUser($id);

            echo json_encode(array('success' => true, 'id' => $id));
        }
    }

    public function changeVisibility(Request $request)
    {
        $user_role = SecuritySystem::currentUserRole();
        if($user_role != ROLE_ADMIN)
        {
            $this->error("access denied");
        }
        else
        {
            $id = $request->getArgument("id");
            $DB = MysqlDevelopersDatabase::getInstance();

            if( $DB->changeVisibility($id) )
            {
                echo json_encode(array('success' => true, 'id' => $id));
            }
            else
            {
                $this->error("database error");
            }
        }
    }

    private function error($message)
    {
        echo json_encode(array('error' => $message) );
    }
}