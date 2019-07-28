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
     * @var Middleware
     */
    protected $last_middleware;
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
        $this->getFirstMiddleware()->last_middleware = $this;
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
    public static function defineChain($name ,Middleware $middleware)
    {
        self::$middlewareCollection [$name] = $middleware->getFirstMiddleware();
    }

    /**
     * @return Middleware
     */
    public function getFirstMiddleware()
    {
        return $this->first_middleware;

    }

    /**
     * @param $name
     * @return Middleware
     */
    public static function getChain($name)
    {
        return self::$middlewareCollection[$name];
    }

    /**
     * @return Middleware
     */
    public function getLastMiddleware()
    {
        return $this->last_middleware;
    }


}
