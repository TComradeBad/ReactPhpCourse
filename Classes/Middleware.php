<?php

namespace tcb\Classes;


class Middleware
{
    /**
     * @var array
     */
    protected static $middlewareCollection;
    /**
     * @var callable
     */
    protected $function;

    /**
     * @var Middleware
     */
    protected $next_function;

    /**
     * @var Middleware
     */
    protected $first_middleware;

    /**
     * @param string $request
     * @param callable $next
     * @return mixed
     */
    public function __invoke($request, callable $next = null)
    {
        $func = $this->function;
        return $func($request,$this->next_function);

    }

    public function __construct(callable $function, callable $first_middleware = null)
    {
        $this->function = $function;
        if(isset($first_middleware))
        {
            $this->first_middleware = $first_middleware;
        }else
        {
            $this->first_middleware = $this;
        }
    }

    /**]
     * @param callable $function
     * @return Middleware
     */
    public function addNext(callable $function)
    {
        $this->next_function = new Middleware($function,$this->first_middleware);
        return $this->next_function;
    }

    /**
     * @param string $name
     * @param Middleware $middleware
     */
    public static function createChain($name ,Middleware $middleware)
    {
        self::$middlewareCollection [$name] = $middleware->getFirstMiddleware();
    }

    /**
     * @return callable
     */
    public function getFirstMiddleware()
    {
        return $this->first_middleware;

    }

    public static function getChain()
    {
        return self::$middlewareCollection;
    }
}
