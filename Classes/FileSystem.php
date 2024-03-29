<?php

namespace tcb\Classes;

use Psr\Http\Message\UploadedFileInterface;
use React\Http\Io\UploadedFile;
use Twig_Loader_Filesystem;
use Twig_Environment;

class FileSystem
{

    protected static $dir_array = [];

    /**
     * @var Twig_Loader_Filesystem
     */
    protected $loader;

    /**
     * @var Twig_Environment
     */
    protected $twig;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem($this->getdir("html_dir"));
        $this->twig = new Twig_Environment($this->loader, array(
            'cache' => $this->getdir('twig_cache')));
    }

    public static function initDirectories($config)
    {
        self::$dir_array = $config;
    }

    public function getdir($dirname)
    {
        return self::$dir_array[$dirname];
    }

    function scanDirectory($dir, $sort = 0)
    {
        $list = scandir($dir, $sort);

        if (!$list) return false;

        if ($sort == 0) unset($list[0], $list[1]);
        else unset($list[count($list) - 1], $list[count($list) - 1]);
        return $list;
    }

    /**
     * @param $pageName string
     * @param $pageArray array
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function page($pageName, $pageArray = array())
    {
        return $this->twig->render($pageName, $pageArray);
    }

    public function css($cssfilename)
    {
        return file_get_contents($this->getdir("css_dir") . "/$cssfilename");
    }

    public function image($imagename)
    {
        return file_get_contents($this->getdir("image_dir") . "/$imagename");
    }

    public function saveImage(UploadedFile $file, $file_name, $innerdir = null)
    {

        $stream = $file->getStream();
        $image = $stream->getContents();
        if (isset($innerdir)) {
            $innerdir = str_replace(" ", "_", $innerdir);
            mkdir($this->getdir("image_dir") . "/$innerdir");
            file_put_contents($this->getdir("image_dir") . "/$innerdir/" . $file_name, $image);
        } else {
            file_put_contents($this->getdir("image_dir") . "/" . $file_name, $image);
        }

    }

    public function deleteImage($filename)
    {
        unlink($this->getdir("image_dir") . "/" . $filename);

    }

    public function imageExist($filename)
    {
        return file_exists($this->getdir("image_dir") . "/" . $filename);
    }


}