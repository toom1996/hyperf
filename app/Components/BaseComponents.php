<?php


namespace App\Components;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

/**
 * Class BaseComponents
 *
 * @author TOOM <1023150697@qq.com>
 *
 */
class BaseComponents
{

    public function __construct($config = [])
    {
    }

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject()
     * @var ResponseInterface
     */
    protected $response;

    protected function _getProperty($name)
    {
        return Context::get($name);
    }

    protected function _setProperty($name, $value)
    {
        return Context::set($name, $value);
    }

//    public function __get($name)
//    {
//        $getter = 'get' . $name;
//        if (method_exists($this, $getter)) {
//            // read property, e.g. getName()
//            return $this->$getter();
//        }
//
//        if (method_exists($this, 'set' . $name)) {
//            //TODO 抛出异常
//            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
//        }
//        //TODO 抛出异常
//        throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
//    }
}