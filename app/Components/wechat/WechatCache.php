<?php


namespace App\Components\wechat;


use App\Components\BaseComponents;
use Psr\SimpleCache\CacheInterface;

class WechatCache extends BaseComponents implements CacheInterface
{


    public function get($key, $default = null)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->get($key);
    }

    public function set($key, $value, $ttl = null)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->set($key, $value, $ttl);
    }

    public function delete($key)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->delete($key);
    }

    public function clear()
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->clear();
    }

    public function getMultiple($keys, $default = null)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->getMultiple($keys);
    }

    public function setMultiple($values, $ttl = null)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->setMultiple($values, $ttl);
    }

    public function deleteMultiple($keys)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->deleteMultiple($keys);
    }

    public function has($key)
    {
        return $this->container->get(\Psr\SimpleCache\CacheInterface::class)->has($key);
    }
}