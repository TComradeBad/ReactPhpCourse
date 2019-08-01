<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 01.08.2019
 * Time: 17:39
 */

namespace tcb\Classes;
use tcbQB\QueryBuilder\AbstractQuery;
use tcbQB\QueryBuilder\QueryBuilder;

class ImageService
{
    protected static $table = "users_images";


    public static function getImageRefArray($images_owner = null)
    {
        $db = new DatabaseService();
        $qbulilder = new QueryBuilder();
        $connection = $db->connect();
        $output = array();
        if($connection)
        {
            if(isset($images_owner))
            {
                $query = $qbulilder->select([self::$table.".id","image_name","file_name","react_users.user_name"])
                    ->from(self::$table)->innerJoin("react_users")->on("owner_id","react_users.id")
                    ->where()->equals("user_name",AbstractQuery::sqlString($images_owner))->get();
            }else
            {
                $query = $qbulilder->select([self::$table.".id","image_name","file_name","react_users.user_name"])
                    ->from(self::$table)->innerJoin("react_users")->on("owner_id","react_users.id")->get();
            }



            $result = $connection->query($query);
            $result = $result->fetchAll();


            foreach ($result as $value)
            {
                $image_item ["href"] = "/image/".$value['user_name']."/".$value["file_name"];
                $image_item ["name"] = $value["image_name"];
                $image_item ["author"] = $value["user_name"];
                $image_item ["id"] = $value["id"];
                $output [] = $image_item;
            }
        }
        return $output;
    }

    public static function getImageById($id)
    {
        $db = new DatabaseService();
        $qbulilder = new QueryBuilder();
        $connection = $db->connect();
        if($connection)
        {
            $query = $qbulilder->select(["image_name","file_name","react_users.user_name"])->from(self::$table)
                ->innerJoin("react_users")->on("owner_id","react_users.id")
                ->where()->equals(self::$table.".id",$id)->get();
            $row = $connection->query($query);
            $row = $row->fetch();

        }
        return $row;
    }
}