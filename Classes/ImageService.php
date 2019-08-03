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
                $query = $qbulilder->select([self::$table.".id","image_name","file_name","react_users.user_name","views_count"])
                    ->from(self::$table)->innerJoin("react_users")->on("owner_id","react_users.id")
                    ->where()->equals("user_name",AbstractQuery::sqlString($images_owner))->get();
            }else
            {
                $query = $qbulilder->select([self::$table.".id","image_name","file_name","react_users.user_name","views_count"])
                    ->from(self::$table)->innerJoin("react_users")->on("owner_id","react_users.id")->get();
            }



            $result = $connection->query($query);
            $result = $result->fetchAll();


            foreach ($result as $value)
            {

                $image_item ["href"] = "/image/".
                    str_replace(" ","_",$value['user_name'])."/".
                    str_replace(" ","_",$value["file_name"]);
                $image_item ["name"] = $value["image_name"];
                $image_item ["authorref"] = str_replace(" ","_",$value["user_name"]);
                $image_item ["author"] = $value["user_name"];
                $image_item ["id"] = $value["id"];
                $image_item ["views_count"] = $value["views_count"];
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
            $query = $qbulilder->select([self::$table.".id","image_name","file_name","react_users.user_name","views_count"])->from(self::$table)
                ->innerJoin("react_users")->on("owner_id","react_users.id")
                ->where()->equals(self::$table.".id",$id)->get();
            $row = $connection->query($query);
            $row = $row->fetch();

        }
        return $row;
    }

    public static function deleteImageById($id)
    {
        $dir = new FileSystem();
        $db = new DatabaseService();
        $qbulilder = new QueryBuilder();
        $row = self::getImageById($id);

        $connection = $db->connect();

        if($connection)
        {
            $query = $qbulilder->delete()->from([self::$table])->where()->equals("id",$id)->get();
            $connection->query($query);
            $dir->deleteImage(str_replace(" ","_",$row["user_name"])."/".$row["file_name"]);

        }

    }

    public static function increaseViewsCountById($id)
    {

        $db = new DatabaseService();
        $qbulilder = new QueryBuilder();
        $row = self::getImageById($id);

        $connection = $db->connect();

        if($connection)
        {
            $row["views_count"] = $row["views_count"] + 1;
            $query = $qbulilder->update(self::$table)->set(["views_count"=>$row["views_count"]])->where()->equals("id",$id)->get();
            $connection->query($query);



        }
    }
}