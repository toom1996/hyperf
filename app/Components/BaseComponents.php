<?php


namespace App\Components;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;
use Hyperf\HttpServer\Contract\ResponseInterface;
/**
 * Class BaseComponents
 *
 * @author TOOM <1023150697@qq.com>
 *
 */
class BaseComponents
{

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
}