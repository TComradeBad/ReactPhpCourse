<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 30.07.2019
 * Time: 17:46
 */

namespace tcb\Classes;


use function PHPSTORM_META\type;

class Handler
{
    protected $function;

    protected $middleware;

    public function __construct(callable  $function, Middleware $middleware = null)
    {
        $this->function = $function;
        $this->middleware = $middleware;
    }

    public function __invoke($request,...$params)
    {   $mid = $this->middleware;
        if(!empty($params))
        {
            $result = $mid($request,null,...array_values($params));
        }else
        {
            $result = $mid($request);
        }


        if(get_class($result)=="tcb\Classes\Middleware")
        {
            $func = $this->function;
            if(!empty($params))
            {
                return $func($request,...array_values($params));

            }else
                {
                return $func($request);
                }

        }else return $result;
    }
}