<?php


namespace qk1e\mysite\model;

use PDOException;
use PDO;
use qk1e\mysite\model\entities\Developer;
use qk1e\mysite\model\entities\Profile;
use qk1e\mysite\model\entities\User;
use qk1e\mysite\model\entities\UserFilter;
use qk1e\mysite\storage\LocalStorage;

trait MysqlUsersDatabase
{

    public function idByLogin($login): int
    {
        $query = "
            SELECT id
            FROM users
            WHERE login = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->execute(array($login));
        $id = $statement->fetch(PDO::FETCH_ASSOC)["id"];

        return $id;
    }

    public function loginById($id): string
    {
        $query = "
            SELECT login
            FROM users
            WHERE id = ?
        ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $id, PDO::PARAM_INT );
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $login = $row["login"];

        return $login;
    }

    public function getUserByLogin(String $login): ?User
    {
        try
        {
            $query = "
                SELECT *
                FROM users
                WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);

            $user = $statement->fetch();

            return $user;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getDeveloperByUserId($id): ?Developer
    {
        try
        {
            $query = "
                SELECT *
                FROM developers
                WHERE `user_id` = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_CLASS, Developer::class);
            $developer = $statement->fetch();

            if($developer)
            {
                return $developer;
            }
            else
            {
                return null;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    private function insertUser($login, $password, $role=ROLE_READER): bool
    {
        try
        {
            $query = "
                INSERT INTO users(`login`, `password`, `role`)
                VALUES (?, ?, ?)
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login, $password, $role));

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }

    }

    //insert into users table. if user is a developer -> insert into developers table and create profile then set profile id to devepers table
    public function registerUser($login, $password, $role = ROLE_READER, $first_name=null, $second_name=null): bool
    {
        try
        {
            $this->DB->beginTransaction();
            $user_created = $this->insertUser($login, $password, $role);

            if(!$user_created)
            {
                $this->DB->rollBack();
                return false;
            }
            else
            {
                //If user is a developer or admin -> insert into developers and create profile
                if($role === ROLE_DEVELOPER || $role === ROLE_ADMIN)
                {
                    $user_id = $this->idByLogin($login);

                    $query = "
                    INSERT INTO developers(`user_id`, `first_name`, `second_name`)
                    VALUES (?,?,?)
                    ";

                    $statement = $this->DB->prepare($query);
                    $statement->bindParam(1, $user_id, PDO::PARAM_INT);
                    $statement->bindParam(2, $first_name, PDO::PARAM_STR);
                    $statement->bindParam(3, $second_name, PDO::PARAM_STR);
                    $statement->execute();

                    $dev_id = $this->DB->lastInsertId();

                    $query = "
                    INSERT INTO profiles(`about`, `dev_id`, `photo`)
                    VALUES (?,?,?)
                ";
                    $statement = $this->DB->prepare($query);
                    $default_photo = LocalStorage::getDefaultPhoto();
                    $default_about = "I have nothing to tell. Just love my job!";
                    $statement->bindParam(1, $default_about, PDO::PARAM_STR);
                    $statement->bindParam(2, $dev_id, PDO::PARAM_INT);
                    $statement->bindParam(3, $default_photo, PDO::PARAM_STR);
                    $statement->execute();

                    $profile_id = $this->DB->lastInsertId();

                    $query = "
                    UPDATE developers
                    SET `profile_id` = ?
                    WHERE `user_id` = ?
                ";
                    $statement = $this->DB->prepare($query);
                    $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
                    $statement->bindParam(2, $user_id, PDO::PARAM_INT);
                    $statement->execute();
                }

                $this->DB->commit();
                return true;
            }

        }
        catch (PDOException $e)
        {
            $this->DB->rollBack();
            return false;
        }
    }


    public function getPasswordByLogin($login): ?string
    {
        try
        {
            $query = "
                SELECT password
                FROM users
                WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            return $statement->fetch(PDO::FETCH_ASSOC)["password"];
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getRole($login): ?string
    {
        try
        {
            $query = "
            SELECT role
            FROM users
            WHERE login = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->execute(array($login));
            $role = $statement->fetch(PDO::FETCH_ASSOC)["role"];

            if($role)
            {
                return $role;
            }
            else
            {
                return "unauthorized";
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getProfileByProfileId($profile_id): ?Profile
    {
        try
        {
            $query = "
            SELECT * 
            FROM profiles
            WHERE `id` = ?
        ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_CLASS, Profile::class);
            $profile = $statement->fetch();

            return $profile;
        }
        catch (PDOException $e)
        {
            return null;
        }

    }

    public function getUsers($filter): ?array
    {
        try
        {
            $query = "
            SELECT users.*, developers.first_name as `first_name`, developers.second_name as `second_name`
            FROM users JOIN developers ON (developers.user_id = users.id)
            ".$this->whereQueryFromUsersFilter($filter);

            $statement = $this->DB->prepare($query);
            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
            $statement->execute();

            $users = array();
            while($user = $statement->fetch())
            {
                if($user->getRole() == ROLE_DEVELOPER || $user->getRole() == ROLE_ADMIN)
                {
                    $developer = new Developer($user);
                    array_push($users, $developer);
                }
                else
                {
                    array_push($users, $user);
                }
            }

            return $users;

        }
        catch (PDOException $e)
        {
            return null;
        }

    }

    private function whereQueryFromUsersFilter(UserFilter $filter): string
    {
        $where = "";

        if($filter)
        {
            $parts = array();

            $role = $filter->getRole();
            if($role)
            {
                if($role !== "any")
                {
                    $part = "`role` LIKE ".$this->DB->quote($role);
                    array_push($parts, $part);
                }
            }

            $login = $filter->getLogin();
            if($login)
            {
                if($login != "")
                {
                    $part = "`login` LIKE ".$this->DB->quote($login);
                    array_push($parts, $part);
                }
            }

            $first_name = $filter->getFirstName();
            if($first_name)
            {
                if($first_name != "")
                {
                    $part = "`first_name` LIKE".$this->DB->quote($first_name);
                    array_push($parts, $part);
                }
            }

            $second_name = $filter->getSecondName();
            if($second_name)
            {
                if($second_name != "")
                {
                    $part = "`second_name` LIKE".$this->DB->quote($second_name);
                    array_push($parts, $part);
                }
            }
        }

        if(!empty($parts))
        {
            $where = "WHERE ";
            foreach ($parts as $part)
            {
                $where = $where.$part." AND ";
            }
            $last_and_pos = strlen($where) - 4;
            $where = substr_replace($where, "", $last_and_pos, 4);
        }

        return $where;
    }

    //not transaction safe
    public function updateUserRole(?int $id, ?string $role): bool
    {

        try
        {
            //update `users` database
            $query = "
            UPDATE users
            SET `role` = ?
            WHERE `id` = ?
        ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $role, PDO::PARAM_STR);
            $statement->bindParam(2, $id, PDO::PARAM_INT);
            $statement->execute();

            //if `role` is a developer or admin
            //  update `developers`

            if($role == ROLE_ADMIN || $role == ROLE_DEVELOPER)
            {
                $query = "
                SELECT count(user_id)
                FROM developers
                WHERE user_id = ?
                GROUP BY user_id
            ";
                $statement = $this->DB->prepare($query);
                $statement->bindParam(1, $id, PDO::PARAM_INT);
                $statement->execute();

                $count = $statement->fetchColumn(0);

                if(!$count)
                {
                    //  create an entry in `developers` and create profile

                    $query = "
                        INSERT INTO developers(`user_id`, `first_name`, `second_name`)
                        VALUES (?,?,?)
                    ";

                    $default_name = "John";
                    $default_surname = "Doe";

                    $statement = $this->DB->prepare($query);
                    $statement->bindParam(1, $id, PDO::PARAM_INT);
                    $statement->bindParam(2, $default_name, PDO::PARAM_STR);
                    $statement->bindParam(3, $default_surname, PDO::PARAM_STR);
                    $statement->execute();


                    $dev = $this->getDeveloperByUserId($id);

                    $query = "
                        INSERT INTO profiles(`dev_id`, `about`)
                        values (?,?)
                    ";

                    $default_about = "I have nothing to tell. Just love my job!";

                    $statement =  $this->DB->prepare($query);
                    $statement->bindParam(1, $dev->getId(), PDO::PARAM_INT);
                    $statement->bindParam(2, $default_about, PDO::PARAM_STR);
                    $statement->execute();

                    $query = "
                        SELECT SCOPE_IDENTITY() as `id`
                    ";
                    $statement = $this->DB->prepare($query);
                    $statement->execute();
                    $profile_id = $statement->fetchColumn(0);

                    $query = "
                        UPDATE developers
                        SET `profile_id` = ?
                        WHERE `id` = ?
                    ";

                    $statement = $this->DB->prepare($query);
                    $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
                    $statement->bindParam(2, $dev->getId(), PDO::PARAM_INT);
                    $statement->execute();
                }
            }
            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    private function deleteFromUserTable($id)
    {
        $query = "
            DELETE FROM users
            WHERE `id`=?
            ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $id, PDO::PARAM_INT);
        $statement->execute();
    }

    private function deleteProfile($profile_id)
    {
        $query = "
                DELETE FROM profiles
                WHERE id=?
                ";

        $statement = $this->DB->prepare($query);
        $statement->bindParam(1, $profile_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteUser(int $id): bool
    {
        try
        {
            //getUserRole
            $role = $this->getUserById($id)->getRole();

            //if role is developer or admin
            if(in_array($role, array(ROLE_DEVELOPER, ROLE_ADMIN)))
            {
                //get profile id
                $query = "
                SELECT profile_id
                FROM developers
                WHERE `user_id` = ?
                ";

                $statement = $this->DB->prepare($query);
                $statement->bindParam(1, $id, PDO::PARAM_INT);
                $statement->execute();

                $profile_id = $statement->fetchColumn(0);

                //  delete profile
                $this->deleteProfile($profile_id);

                //  delete from developers
                $query = "
                    DELETE FROM developers
                    WHERE user_id=?
                ";

                $statement = $this->DB->prepare($query);
                $statement->bindParam(1, $id, PDO::PARAM_INT);
                $statement->execute();

            }

            //delete user
            $this->deleteFromUserTable($id);

            return true;


        }
        catch (PDOException $e)
        {
            return false;
        }

    }

    private function getPhotoByDeveloperId($developer_id): ?string
    {
        try
        {
            $query = "
                SELECT photo
                FROM profiles
                WHERE `dev_id` = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $developer_id, PDO::PARAM_INT);
            $statement->execute();

            $photo = $statement->fetch(PDO::FETCH_ASSOC)["photo"];

            return $photo;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return null;
        }
    }

    public function getUserById(int $id): ?User
    {
        try
        {
            $query = "
                SELECT *
                FROM users
                WHERE `id` = ?
            ";

            $statement = $this->DB->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_CLASS, User::class);

            $user = $statement->fetch();

            return $user;
        }
        catch (PDOException $e)
        {
            return null;
        }
    }
}