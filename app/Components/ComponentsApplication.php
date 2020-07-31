<?php


namespace App\Components;


use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;

/**
 * Class ComponentsApplication
 *
 * @author: TOOM <1023150697@qq.com>
 */
class ComponentsApplication
{

    /**
     * @\Hyperf\Di\Annotation\Inject()
     * @var \App\Components\ComponentsContainer
     */
    public static $app;

}

