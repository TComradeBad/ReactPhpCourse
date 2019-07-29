<?php
/**
 * Created by PhpStorm.
 * User: Комрад
 * Date: 29.07.2019
 * Time: 21:24
 */

namespace tcb\Classes;
use tcb\Classes\Middleware;

class MiddlewareFactory
{
    protected $function_collection = array();

    public function addFunction(callable $func)
    {
        $this->function_collection [] = $func;
    }

    public function createMiddlewareChain()
    {
        $mid = new \tcb\Classes\Middleware();
        $mid->setFunction($this->function_collection[0]);
        $mid2 = $mid;
        for ($i=1 ; $i < count($this->function_collection); $i++)
        {
            $mid2 = $mid2->addNext($this->function_collection[$i]);
        }
        return $mid;
    }

}