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
    protected $function_chain = array();

    protected static $chain_collection = array();

    public function addFunction(callable $func)
    {
        $this->function_chain [] = $func;
        return $this;
    }
    public static function addFunctionToChain($name, callable $func)
    {
        self::$chain_collection [$name] [] = $func;
    }

    public static function createMiddlewareChain($function_chain)
    {
        $mid = new \tcb\Classes\Middleware();
        $mid->setFunction($function_chain[0]);
        $mid2 = $mid;
        for ($i=1 ; $i < count($function_chain); $i++)
        {
            $mid2 = $mid2->addNext($function_chain[$i]);
        }
        return $mid;
    }

    public function defineFunctionChain($name)
    {
        self::$chain_collection [$name] = $this->function_chain;
    }

    public static function getFunctionChain($name)
    {
        return self::$chain_collection [$name];
    }
}
