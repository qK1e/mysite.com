<?php
namespace qk1e\mysite\storage;

class LocalStorage
{
    private static $path = "/storage";

    private static $def_photo = "default/def-avatar.png";

    public static function saveImage($file)
    {
        $destination = ROOTDIR.self::$path;
        $file_id = self::generateUniqueId( $file["name"] );
        self::checkPath();

        move_uploaded_file($file["tmp_name"], $destination."/$file_id");
        return $file_id;
    }

    public static function getFilePath($file_id)
    {
        return self::$path."/".$file_id;
    }

    public static function getDefaultPhoto(): string
    {
        return self::$def_photo;
    }
    private static function generateUniqueId($file_name)
    {
        $name_exploded = explode(".", $file_name);
        $prefix = $name_exploded[0];
        $ext =  end($name_exploded);
        $new_name = uniqid($prefix).".$ext";
        return $new_name;
    }

    private static function checkPath()
    {
         if(!file_exists(ROOTDIR.self::$path))
         {
             mkdir(ROOTDIR.self::$path, 0777, true);
         }
    }


}