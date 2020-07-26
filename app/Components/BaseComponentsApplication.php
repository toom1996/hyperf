<?php


namespace App\Components;


use Hyperf\Utils\Context;

class BaseComponentsApplication
{


    protected function _getProperty($name)
    {
        return Context::get($name);
    }

    protected function _setProperty($name, $value)
    {
        return Context::set($name, $value);
    }

}