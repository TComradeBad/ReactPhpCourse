<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 31.07.2019
 * Time: 17:16
 */

namespace tcb\Classes;


use Psr\Http\Message\UploadedFileInterface;
use React\Http\Io\UploadedFile;
use tcb\Classes\DatabaseService;
use tcbQB\QueryBuilder\QueryBuilder;
use tcbQB\QueryBuilder\AbstractQuery;

class Image
{
    /**
     * @var UploadedFile
     */
    protected $image;

    protected $id;

    protected $file_name;

    protected $image_name;

    protected $owner_id;

    protected $table = "users_images";


    public function __construct(UploadedFile $file, $image_name, $owner, $id = null)
    {
        $this->image = $file;
        $this->file_name = $this->image->getClientFilename();
        $this->image_name = $image_name;
        $this->owner = $owner;
        $this->id = $id;
    }

    /**
     * @throws \Exception
     */
    public function saveImagePushToDb()
    {

        $dir = new FileSystem();
        $db = new DatabaseService();


        $connection = $db->connect();
        if (!$connection) {
            throw new \Exception("Failed to connect to Database" . $connection->errorInfo());

        } else {
            $qb = new QueryBuilder();

            $query1 = $qb->select(["id", "user_name"])->from(["react_users"])->where()
                ->equals("user_name", AbstractQuery::sqlString($this->owner))->get();

            $row = $connection->query($query1);
            $row = $row->fetch();

            $image_exist = $dir->imageExist(str_replace(" ", "_", $row["user_name"]) . "/" .
                str_replace(" ", "_", $this->file_name));

            if ($image_exist) {
                $this->file_name = md5($this->file_name);
            }
            $query2 = $qb->insert($this->table, ["image_name", "file_name", "owner_id"])->values(
                [
                    AbstractQuery::sqlString($this->image_name),
                    AbstractQuery::sqlString($this->file_name),
                    $row["id"]
                ]
            )->get();

            $connection->query($query2);
            $dir->saveImage($this->image, $this->file_name, $this->owner);
        }
    }


}