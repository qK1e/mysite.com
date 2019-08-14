<?php
namespace qk1e\mysite\storage;

class LocalStorage
{
    private static $path = "/storage";

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
         if(!file_exists(self::$path))
         {
             mkdir(self::$path, 0777, true);
         }
    }
}